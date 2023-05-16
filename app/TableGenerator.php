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
    public function generateForCurrentDay(int $time): array
    {
        [$startDay, $endDay] =  TestDataGenerator::getStartAndEndDay($time);
        return $this->databaseManager->get(
            [
                ['date', $startDay, '>='],
                ['date', $endDay, '<='],
            ],
            [
                'date DESC'
            ],
        );
    }

    /**
     * @throws MysqlException
     */
    public function generateForCurrentWeek(int $time): array
    {
        [$startWeek, $endWeek] =  TestDataGenerator::getStartAndEndWeek($time);
        return $this->databaseManager->get(
            [
                ['date', $startWeek, '>='],
                ['date', $endWeek, '<='],
            ],
            [
                'date DESC'
            ],
        );
    }

    /**
     * @throws MysqlException
     */
    public function generateForCurrentMonth(int $time): array
    {
        [$startMonth, $endMonth] =  TestDataGenerator::getStartAndEndMonth($time);
        return $this->databaseManager->get(
            [
                ['date', $startMonth, '>='],
                ['date', $endMonth, '<='],
            ],
            [
                'date DESC'
            ],
        );
    }
}