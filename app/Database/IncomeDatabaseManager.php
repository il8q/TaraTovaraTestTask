<?php

namespace App\Database;

use App\Entity\Income;
use App\EntitySerializer;
use Simplon\Mysql\Mysql;
use Simplon\Mysql\MysqlException;
use Simplon\Mysql\QueryBuilder\ReadQueryBuilder;

class IncomeDatabaseManager implements IncomeDatabaseManagerInterface
{
    const EXIST_TABLE_CODE_EXCEPTION = '42S01';
    const EXIST_ROW_CODE_EXCEPTION = '23000';
    const COLUMN_ORDER = [
        Income::ID_LABEL,
        Income::AMOUNT_IN_LABEL,
        Income::AMOUNT_OUT_LABEL,
        Income::DATE_LABEL,
    ];

    public function __construct(
        private readonly Mysql $connection,
    )
    {
    }

    /**
     * @throws MysqlException
     */
    public function find(
        array $params,
        ?int $limit = null,
        ?int $offset = null,
    ): array
    {
        $sql = $this->generateSql($params, $limit, $offset);
        $rows = $this->connection->fetchRowMany($sql);
        return EntitySerializer::serializeIncomesFromArray($rows);
    }

    /**
     * @throws MysqlException
     */
    public function findAndSegment(array $params): array
    {
        $sql = $this->generateSegmentSql($params);
        $result = $this->connection->fetchRowMany($sql) ?? [];
        if (count($result)) {
            $result = $this->setPeriodLabel($result, $params['segmentationVariable'], $params['periodHash']);
        }
        return $result;
    }

    /**
     * @throws MysqlException
     */
    public function createTable()
    {
        $command = "CREATE TABLE `tara_tovara`.`income`
        (
            `id` INT NOT NULL AUTO_INCREMENT , PRIMARY KEY (`id`), 
            `date` BIGINT NOT NULL, 
            `amount_in` FLOAT NOT NULL,
            `amount_out` FLOAT NOT NULL 
        )
        ENGINE = InnoDB;";
        try {
            $this->connection->executeSql($command);
        } catch (\Exception $exception) {
            if ($exception->getCode() != self::EXIST_TABLE_CODE_EXCEPTION) {
                throw $exception;
            }
        }
    }

    /**
     * @throws MysqlException
     */
    public function save(array $data)
    {
        try {
            $this->connection->insert('income', $data);
        } catch (\Exception $exception) {
            if ($exception->getCode() != self::EXIST_ROW_CODE_EXCEPTION) {
                throw $exception;
            }
        }
    }

    /**
     * @param array $criteria
     * @param array $order
     * @param int|null $limit
     * @param int|null $offset
     * @return string
     */
    private function generateSql(
        array $params,
        ?int $limit,
        ?int $offset
    ): string
    {
        $query = $this->generateQueryForFindRequest($params['order']);
        if ($limit) {
            $query->setLimit($limit);
        }
        if ($offset) {
            $query->setLimit($offset);
        }

        // Этот костыль компенсирует невозможность добавить проверку на принадлежность
        // даты промежутку. ReadQueryBuilder может хранить только одно условие для конкеретной колонки
        return str_replace(
            "`date` = :date",
            QueryHelper::generateCriteriaString($params['criteria']),
            $query->renderQuery()
        );
    }

    /**
     * @param array $order
     * @return ReadQueryBuilder
     */
    public function generateQueryForFindRequest(array $order): ReadQueryBuilder
    {
        $query = new ReadQueryBuilder();
        $query->setSelect(self::COLUMN_ORDER);
        $query->setFrom(Income::TABLE_NAME);
        $query->addCondition('date', '1');
        $query->setSorting($order);
        return $query;
    }

    private function generateSegmentSql(array $params): string
    {
        $query = new ReadQueryBuilder();
        $query->setSelect([
            sprintf("sum(%s)", Income::AMOUNT_IN_LABEL),
            sprintf("sum(%s)", Income::AMOUNT_OUT_LABEL),
            sprintf("%s as %s", $params['segmentationFunction'], $params['segmentationVariable'])
        ]);
        $query->setFrom(Income::TABLE_NAME);
        $query->addCondition('date', '1');
        $query->setSorting($params['order']);
        $query->setGroup([$params['segmentationVariable']]);
        return str_replace(
            "`date` = :date",
            QueryHelper::generateCriteriaString($params['criteria']),
            $query->renderQuery()
        );
    }

    private function setPeriodLabel(array $result, string $variableLabel, int $hash): array
    {
        foreach ($result as &$row) {
            $startPeriod = &$row[$variableLabel];
            $startPeriod *= $hash;
            $startPeriod = date('Y-m-d H:I:s', $startPeriod);
        }
        return $result;
    }
}