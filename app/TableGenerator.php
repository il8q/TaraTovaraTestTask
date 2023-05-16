<?php

namespace App;

use App\Database\DatabaseManagerFactory;
use App\Database\IncomeDatabaseManagerInterface;
use Exception;
use Simplon\Mysql\MysqlException;

class TableGenerator
{
    const COLUMN_NAMES = [
        'id',
        'Доход',
        'Расход',
        'Дата',
    ];
    
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
        $incomes = $this->databaseManager->find(
            [
                ['date', $startDay, '>='],
                ['date', $endDay, '<='],
            ],
            [
                'date DESC'
            ],
        );
        return [
            'headers' => self::COLUMN_NAMES,
            'rows' => EntitySerializer::serializeIncomeArray($incomes),
        ];
    }

    /**
     * @throws MysqlException
     */
    public function generateForCurrentWeek(int $time): array
    {
        [$startWeek, $endWeek] =  TestDataGenerator::getStartAndEndWeek($time);
        $incomes = $this->databaseManager->find(
            [
                ['date', $startWeek, '>='],
                ['date', $endWeek, '<='],
            ],
            [
                'date DESC'
            ],
        );
        return [
            'headers' => self::COLUMN_NAMES,
            'rows' => EntitySerializer::serializeIncomeArray($incomes),
        ];
    }

    /**
     * @throws MysqlException
     */
    public function generateForCurrentMonth(int $time): array
    {
        [$startMonth, $endMonth] =  TestDataGenerator::getStartAndEndMonth($time);
        $incomes =  $this->databaseManager->find(
            [
                ['date', $startMonth, '>='],
                ['date', $endMonth, '<='],
            ],
            [
                'date DESC'
            ],
        );
        return [
            'headers' => self::COLUMN_NAMES,
            'rows' => EntitySerializer::serializeIncomeArray($incomes),
        ];
    }
}