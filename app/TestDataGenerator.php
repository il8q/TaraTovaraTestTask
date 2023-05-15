<?php

namespace App;
use Exception;

class TestDataGenerator
{
    /**
     * @throws Exception
     */
    public static function createData(): void
    {
        $databaseManager = DatabaseManagerFactory::createIncomeManager();
        $databaseManager->create();
        $databaseManager->update([
            'id' => 1,
            'date' => 1,
            'amount_in' => 2,
            'amount_out' => 3,
        ]);
    }
}