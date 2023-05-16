<?php

namespace App;

use App\database\IncomeDatabaseManagerInterface;
use DateTime;
use Exception;

class TestDataGenerator
{
    const SECONDS_PER_MINUTE = 60;
    const SECONDS_PER_HOUR = 60 * self::SECONDS_PER_MINUTE;
    const SECONDS_PER_DAY = 24 * self::SECONDS_PER_HOUR;
    const SECONDS_PER_WEEK = 7 * self::SECONDS_PER_DAY;

    /**
     * @throws Exception
     */
    public static function createData(): void
    {
        $databaseManager = DatabaseManagerFactory::createIncomeManager();
        $databaseManager->createTable();

        self::generateForLastDay($databaseManager);
        self::generateForLastWeek($databaseManager);
        self::generateForLastMounth($databaseManager);
    }

    private static function generateForLastDay(IncomeDatabaseManagerInterface $databaseManager): void
    {
        $databaseManager->save([
            'id' => 1,
            'date' => time(),
            'amount_in' => 2.0,
            'amount_out' => 3.0,
        ]);

        $databaseManager->save([
            'id' => 3,
            'date' => time() - self::SECONDS_PER_HOUR,
            'amount_in' => 22.0,
            'amount_out' => 1.0,
        ]);

        $databaseManager->save([
            'id' => 2,
            'date' => time() - 2 * self::SECONDS_PER_HOUR,
            'amount_in' => 9.0,
            'amount_out' => 89.0,
        ]);
        $databaseManager->save([
            'id' => 4,
            'date' => time() - 2 * self::SECONDS_PER_HOUR - 5,
            'amount_in' => 19.0,
            'amount_out' => 21.0,
        ]);
        $databaseManager->save([
            'id' => 5,
            'date' => time() - 2 * self::SECONDS_PER_HOUR - 15,
            'amount_in' => 73.0,
            'amount_out' => 5.0,
        ]);
    }

    private static function generateForLastWeek(IncomeDatabaseManagerInterface $databaseManager): void
    {
        $databaseManager->save([
            'id' => 6,
            'date' => time() - 2 * self::SECONDS_PER_DAY - 15,
            'amount_in' => 3.0,
            'amount_out' => 65.0,
        ]);
        $databaseManager->save([
            'id' => 7,
            'date' => time() - 2 * self::SECONDS_PER_DAY - 15,
            'amount_in' => 2.0,
            'amount_out' => 1.0,
        ]);
        $databaseManager->save([
            'id' => 8,
            'date' => time() - 4 * self::SECONDS_PER_DAY,
            'amount_in' => 27.0,
            'amount_out' => 63.0,
        ]);
        $databaseManager->save([
            'id' => 9,
            'date' => time() - 4 * self::SECONDS_PER_DAY,
            'amount_in' => 227.0,
            'amount_out' => 163.0,
        ]);
        $databaseManager->save([
            'id' => 10,
            'date' => time() - 4 * self::SECONDS_PER_DAY - 99,
            'amount_in' => 29.0,
            'amount_out' => 53.0,
        ]);
    }

    private static function generateForLastMounth(IncomeDatabaseManagerInterface $databaseManager): void
    {
        $databaseManager->save([
            'id' => 12,
            'date' => time() - 2 * self::SECONDS_PER_WEEK - 99,
            'amount_in' => 99.0,
            'amount_out' => 11.0,
        ]);
        $databaseManager->save([
            'id' => 13,
            'date' => time() - 2 * self::SECONDS_PER_WEEK - 3 * self::SECONDS_PER_DAY - 99,
            'amount_in' => 56.0,
            'amount_out' => 77.0,
        ]);
        $databaseManager->save([
            'id' => 11,
            'date' => time() - 2 * self::SECONDS_PER_WEEK - self::SECONDS_PER_DAY,
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
        $day = date('w', $time);
        return [
            strtotime(date('Y-m-d 00:00:00', strtotime('-'.$day.' days'))),
            strtotime(date('Y-m-d 23:59:59', strtotime('+'.(6-$day).' days')))
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