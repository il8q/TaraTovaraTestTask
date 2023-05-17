<?php

namespace App;

use App\Database\DatabaseManagerFactory;
use App\Database\IncomeDatabaseManagerInterface;
use Exception;
use Simplon\Mysql\MysqlException;

class TableGenerator
{
    const COLUMN_NAMES = [
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
        $incomes = $this->databaseManager->findAndSegment([
            'criteria' => [
                ['date', $startDay, '>='],
                ['date', $endDay, '<='],
            ],
            'order' => [
                'segment_id ASC'
            ],
            'segmentationFunction' => sprintf("FLOOR(date/%s)", TestDataGenerator::SECONDS_PER_HOUR),
            'segmentationVariable' => 'segment_id',
            'periodHash' => TestDataGenerator::SECONDS_PER_HOUR,
        ]);
        return [
            'headers' => self::COLUMN_NAMES,
            'rows' => $incomes,
        ];
    }

    /**
     * @throws MysqlException
     */
    public function generateForCurrentWeek(int $time): array
    {
        [$startWeek, $endWeek] =  TestDataGenerator::getStartAndEndWeek($time);
        $incomes = $this->databaseManager->findAndSegment([
            'criteria' => [
                ['date', $startWeek, '>='],
                ['date', $endWeek, '<='],
            ],
            'order' => [
                'segment_id ASC'
            ],
            'segmentationFunction' => sprintf("FLOOR(date/%s)", TestDataGenerator::SECONDS_PER_DAY),
            'segmentationVariable' => 'segment_id',
            'periodHash' => TestDataGenerator::SECONDS_PER_DAY,
        ]);
        return [
            'headers' => self::COLUMN_NAMES,
            'rows' => $incomes,
        ];
    }

    /**
     * @throws MysqlException
     */
    public function generateForCurrentMonth(int $time): array
    {
        [$startMonth, $endMonth] =  TestDataGenerator::getStartAndEndMonth($time);
        $incomes =  $this->databaseManager->findAndSegment([
            'criteria' => [
                ['date', $startMonth, '>='],
                ['date', $endMonth, '<='],
            ],
            'order' => [
                'segment_id ASC'
            ],
            'segmentationFunction' => sprintf("FLOOR(date/%s)", TestDataGenerator::SECONDS_PER_WEEK),
            'segmentationVariable' => 'segment_id',
            'periodHash' => TestDataGenerator::SECONDS_PER_WEEK,
        ]);
        return [
            'headers' => self::COLUMN_NAMES,
            'rows' => $incomes,
        ];
    }
}