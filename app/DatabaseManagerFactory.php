<?php

namespace App;

use App\database\IncomeDatabaseManager;
use Exception;
use Simplon\Mysql\Crud\CrudStore;

class DatabaseManagerFactory
{
    /**
     * @throws Exception
     */
    public static function createIncomeManager(): IncomeDatabaseManager
    {
        return new IncomeDatabaseManager(
            DatabaseConnectionFactory::create()
        );
    }
}