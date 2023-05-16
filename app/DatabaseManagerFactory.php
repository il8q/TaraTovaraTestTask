<?php

namespace App;

use App\database\IncomeDatabaseManager;
use App\database\IncomeDatabaseManagerInterface;
use Exception;
use Simplon\Mysql\Crud\CrudStore;

class DatabaseManagerFactory
{
    /**
     * @throws Exception
     */
    public static function createIncomeManager(): IncomeDatabaseManagerInterface
    {
        return new IncomeDatabaseManager(
            DatabaseConnectionFactory::create()
        );
    }
}