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
        TableViewGenerator::generate($tableGenerator->generate())
            . TableViewGenerator::generate($tableGenerator->generate())
            . TableViewGenerator::generate($tableGenerator->generate()),
    );
} catch (Throwable $exception) {
    echo $exception->getMessage();
    echo '<p>';
    echo implode($exception->getTrace());
}

