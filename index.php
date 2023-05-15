<?php

use App\PageGenerator;
use App\TableGenerator;
use App\TableViewGenerator;

require_once 'vendor/autoload.php';

try {
    $tableGenerator = new TableGenerator();
    echo PageGenerator::renderHtml(
        'Доходы и расходы',
        TableViewGenerator::generate($tableGenerator->generate()),
    );
} catch (Exception $exception) {
    echo $exception->getMessage();
    echo '<p>';
    echo implode($exception->getTrace());
}

