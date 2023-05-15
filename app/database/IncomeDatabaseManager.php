<?php

namespace App\database;

use Simplon\Mysql\Mysql;
use Simplon\Mysql\MysqlException;

class IncomeDatabaseManager implements IncomeDatabaseManagerInterface
{
    const EXIST_TABLE_CODE_EXCEPTION = '42S01';

    /**
     * @param Mysql $connection
     */
    public function __construct(
        private Mysql $connection,
    )
    {
    }

    public function get(
        array $criteria,
        ?int $limit,
        ?int $offset
    ): array
    {
        return [
            'headers' => ['title', 'cell'],
            'rows' => [
                ['1', '2'],
                ['2', '3'],
            ],
        ];
    }

    /**
     * @throws MysqlException
     */
    public function create()
    {
        $command = "CREATE TABLE `tara_tovara`.`income`
        (
            `id` INT NOT NULL AUTO_INCREMENT , PRIMARY KEY (`id`), 
            `date` BIGINT NOT NULL, 
            `amount_in` INT NOT NULL,
            `amount_out` INT NOT NULL 
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
    public function update(array $data)
    {
        $this->connection->update('income', [], $data);
    }
}