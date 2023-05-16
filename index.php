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
        TableViewGenerator::generate('За месяц', $tableGenerator->generate())
            . TableViewGenerator::generate('За неделю', $tableGenerator->generate())
            . TableViewGenerator::generate('За день', $tableGenerator->generate()),
    );
    throw new Exception('sdf');
} catch (Throwable $exception) {
    echo '<p>';
    echo $exception->getMessage();
    echo '<p>';
    var_dump($exception->getTrace());
}

