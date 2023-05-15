<?php

namespace App;

use App\database\IncomeDatabaseManager;
use Exception;

class TableGenerator
{
    private IncomeDatabaseManager $databaseManager;

    /**
     * @throws Exception
     */
    public function __construct()
    {
        $this->databaseManager = DatabaseManagerFactory::createIncomeManager();
    }

    public function generate(): array
    {
        return $this->databaseManager->get([
            'id' => 1,
        ], 1, 0);
    }
}