<?php

namespace App\database;

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
    public function get(
        array $criteria,
        array $order,
        ?int $limit = null,
        ?int $offset = null,
    ): array
    {
        $sql = $this->generateSql($criteria, $order, $limit, $offset);
        $rows = $this->connection->fetchRowMany($sql);
        return EntitySerializer::serializeIncomesFromArray($rows);
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
    public function generateSql(
        array $criteria,
        array $order,
        ?int $limit,
        ?int $offset
    ): string
    {
        $query = new ReadQueryBuilder();
        $query->setSelect(self::COLUMN_ORDER);
        $query->setFrom(Income::TABLE_NAME);
        $query->addCondition('date', '1');
        $query->setSorting($order);
        if ($limit) {
            $query->setLimit($limit);
        }
        if ($offset) {
            $query->setLimit($offset);
        }

        return str_replace(
            "`date` = :date",
            QueryHelper::generateCriteriaString($criteria),
            $query->renderQuery()
        );
    }
}