<?php

namespace App;

use App\database\IncomeDatabaseManager;
use App\database\IncomeDatabaseManagerInterface;
use Exception;

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