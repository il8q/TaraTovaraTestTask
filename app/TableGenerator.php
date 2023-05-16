<?php

namespace App;

use App\database\IncomeDatabaseManagerInterface;
use Exception;
use Simplon\Mysql\MysqlException;

class TableGenerator
{
    private IncomeDatabaseManagerInterface $databaseManager;

    /**
     * @throws Exception
     */
    public function __construct()
    {
        $this->databaseManager = DatabaseManagerFactory::createIncomeManager();
    }

    /**
     * @throws MysqlException
     */
    public function generate(): array
    {
        return $this->databaseManager->get(
            [
                //'id' => 1,
            ],
            [
                'date DESC'
            ],
            1,
            0
        );
    }
}