<?php

namespace App;

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