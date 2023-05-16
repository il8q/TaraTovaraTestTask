<?php

namespace App\database;

use Simplon\Mysql\Mysql;
use Simplon\Mysql\MysqlException;
use Simplon\Mysql\QueryBuilder\ReadQueryBuilder;

class IncomeDatabaseManager implements IncomeDatabaseManagerInterface
{
    const EXIST_TABLE_CODE_EXCEPTION = '42S01';
    const EXIST_ROW_CODE_EXCEPTION = '23000';

    /**
     * @param Mysql $connection
     */
    public function __construct(
        private Mysql $connection,
    )
    {
    }

    /**
     * @throws MysqlException
     */
    public function get(
        array $criteria,
        array $order,
        ?int $limit,
        ?int $offset
    ): array
    {
        $query = new ReadQueryBuilder();
        $query->addSelect('*');
        $query->setFrom(IncomeTableRow::TABLE_NAME);
        $query->setConditions($criteria);
        $query->setSorting($order);

        $rows = $this->connection->fetchRowMany($query->renderQuery());
        /*$rows = $this->connection->fetchRowMany(sprintf(
            "SELECT * FROm %s WHERE %s ORDER BY %s",
            IncomeTableRow::TABLE_NAME,
            QueryHelper::generateCriteriaString($criteria),
            QueryHelper::generateOrderString($order)
        ));*/
        return [
            'headers' => [
                IncomeTableRow::COLUMN_ID,
                IncomeTableRow::COLUMN_DATE,
                IncomeTableRow::COLUMN_AMOUNT_IN,
                IncomeTableRow::COLUMN_AMOUNT_OUT
            ],
            'rows' => $rows,
        ];
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
}