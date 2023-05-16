<?php
require_once 'vendor/autoload.php';

use App\PageBuilder;
use App\PageDirector;
use App\PageGenerator;
use App\TableGenerator;
use App\TableViewDirector;
use App\TestDataGenerator;

try {
    TestDataGenerator::createData();
    $director = new PageDirector(new PageBuilder());
    echo $director->construct('Доходы и расходы');
} catch (Throwable $exception) {
    echo '<p>';
    echo $exception->getMessage();
    echo '<p>';
    var_dump($exception->getTrace());
}

