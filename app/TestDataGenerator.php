<?php

namespace App;

use App\Database\DatabaseManagerFactory;
use App\Database\IncomeDatabaseManagerInterface;
use Exception;

/**
 * Генерирует тестовые данные.
 * В этом классе не нужно использовать паттерн строитель, потому что
 * дальнейшее изменение и улучшение класса не предполагается
 */
class TestDataGenerator
{
    const SECONDS_PER_MINUTE = 60;
    const SECONDS_PER_HOUR = 60 * self::SECONDS_PER_MINUTE;
    const SECONDS_PER_DAY = 24 * self::SECONDS_PER_HOUR;
    const SECONDS_PER_WEEK = 7 * self::SECONDS_PER_DAY;
    const SUNDAY_ID = 0;
    const TEST_TIME = 1684233225;// Tue May 16 2023 13:33:45 GMT+0300 (Москва, стандартное время)
    
    /**
     * @throws Exception
     */
    public static function createData(): void
    {
        $databaseManager = DatabaseManagerFactory::createIncomeManager();
        $databaseManager->createTable();
        
        self::generateForLastDay($databaseManager);
        self::generateForLastWeek($databaseManager);
        self::generateForLastMonth($databaseManager);
    }

    private static function generateForLastDay(IncomeDatabaseManagerInterface $databaseManager): void
    {
        $databaseManager->save([
            'id' => 1,
            'date' => self::TEST_TIME,
            'amount_in' => 2.0,
            'amount_out' => 3.0,
        ]);

        $databaseManager->save([
            'id' => 3,
            'date' => self::TEST_TIME - self::SECONDS_PER_HOUR,
            'amount_in' => 22.0,
            'amount_out' => 1.0,
        ]);

        $databaseManager->save([
            'id' => 2,
            'date' => self::TEST_TIME - 2 * self::SECONDS_PER_HOUR,
            'amount_in' => 9.0,
            'amount_out' => 89.0,
        ]);
        $databaseManager->save([
            'id' => 4,
            'date' => self::TEST_TIME - 2 * self::SECONDS_PER_HOUR - 5,
            'amount_in' => 19.0,
            'amount_out' => 21.0,
        ]);
        $databaseManager->save([
            'id' => 5,
            'date' => self::TEST_TIME - 2 * self::SECONDS_PER_HOUR - 15,
            'amount_in' => 73.0,
            'amount_out' => 5.0,
        ]);
    }

    private static function generateForLastWeek(IncomeDatabaseManagerInterface $databaseManager): void
    {
        $databaseManager->save([
            'id' => 6,
            'date' => self::TEST_TIME - 2 * self::SECONDS_PER_DAY - 15,
            'amount_in' => 3.0,
            'amount_out' => 65.0,
        ]);
        $databaseManager->save([
            'id' => 7,
            'date' => self::TEST_TIME - 2 * self::SECONDS_PER_DAY - 15,
            'amount_in' => 2.0,
            'amount_out' => 1.0,
        ]);
        $databaseManager->save([
            'id' => 8,
            'date' => self::TEST_TIME - 4 * self::SECONDS_PER_DAY,
            'amount_in' => 27.0,
            'amount_out' => 63.0,
        ]);
        $databaseManager->save([
            'id' => 9,
            'date' => self::TEST_TIME - 4 * self::SECONDS_PER_DAY,
            'amount_in' => 227.0,
            'amount_out' => 163.0,
        ]);
        $databaseManager->save([
            'id' => 10,
            'date' => self::TEST_TIME - 4 * self::SECONDS_PER_DAY - 99,
            'amount_in' => 29.0,
            'amount_out' => 53.0,
        ]);
        $databaseManager->save([
            'id' => 15,
            'date' => self::TEST_TIME - self::SECONDS_PER_DAY - 99,
            'amount_in' => 29.0,
            'amount_out' => 53.0,
        ]);
    }

    private static function generateForLastMonth(IncomeDatabaseManagerInterface $databaseManager): void
    {
        $databaseManager->save([
            'id' => 12,
            'date' => self::TEST_TIME - 2 * self::SECONDS_PER_WEEK - 99,
            'amount_in' => 99.0,
            'amount_out' => 11.0,
        ]);
        $databaseManager->save([
            'id' => 13,
            'date' => self::TEST_TIME - 2 * self::SECONDS_PER_WEEK - 3 * self::SECONDS_PER_DAY - 99,
            'amount_in' => 56.0,
            'amount_out' => 77.0,
        ]);
        $databaseManager->save([
            'id' => 11,
            'date' => self::TEST_TIME - 2 * self::SECONDS_PER_WEEK - self::SECONDS_PER_DAY,
            'amount_in' => 33.0,
            'amount_out' => 41.0,
        ]);
        $databaseManager->save([
            'id' => 14,
            'date' => self::TEST_TIME - 4 * self::SECONDS_PER_WEEK - self::SECONDS_PER_DAY,
            'amount_in' => 33.0,
            'amount_out' => 41.0,
        ]);
    }

    public static function getStartAndEndMonth(int $date): array
    {
        return [
            strtotime(date('Y-m-01 00:00:00', $date)),
            strtotime(date('Y-m-t 23:59:59', $date))
        ];
    }

    public static function getStartAndEndWeek(int $time): array
    {
        $day = (int)date('w', $time);
        if ($day == self::SUNDAY_ID) {
            return self::getStartAndEndDay($time);
        }
        $day--;
        return [
            strtotime('-'.$day.' days 00:00:00'),
            strtotime('+'.(6-$day).' days 23:59:59'),
        ];
    }

    public static function getStartAndEndDay(int $time): array
    {
        return [
            strtotime(date('Y-m-d 00:00:00', $time)),
            strtotime(date('Y-m-d 23:59:59', $time))
        ];
    }
}