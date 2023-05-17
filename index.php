<?php
require_once 'vendor/autoload.php';

use App\PageBuilder;
use App\PageDirector;
use App\TestDataGenerator;

try {
    TestDataGenerator::createData();
    $director = new PageDirector(new PageBuilder());
    // Выбрана дата Tue May 16 2023 00:00:01
    echo $director->construct('Доходы и расходы', 1684195201);
} catch (Throwable $exception) {
    echo '<p>';
    echo $exception->getMessage();
    echo '<p>';
    var_dump($exception->getTrace());
}

