<?php

namespace App\database;

interface IncomeDatabaseManagerInterface
{
    public function createTable();
    public function save(array $data);
}