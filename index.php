<?php

use App\PageGenerator;
use App\TableGenerator;
use App\TableViewGenerator;
use App\TestDataGenerator;

require_once 'vendor/autoload.php';

try {
    TestDataGenerator::createData();
    $tableGenerator = new TableGenerator();
    echo PageGenerator::renderPage(
        'Доходы и расходы',
        TableViewGenerator::generate(
                'За месяц',
                $tableGenerator->generateForCurrentMonth(time())
            )
            . TableViewGenerator::generate(
                'За неделю',
                $tableGenerator->generateForCurrentWeek(time())
            )
            . TableViewGenerator::generate(
                'За день',
                $tableGenerator->generateForCurrentDay(time())
            ),
    );
} catch (Throwable $exception) {
    echo '<p>';
    echo $exception->getMessage();
    echo '<p>';
    var_dump($exception->getTrace());
}

