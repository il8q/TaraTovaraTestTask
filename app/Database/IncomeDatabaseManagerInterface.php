<?php

namespace App\Database;

interface IncomeDatabaseManagerInterface
{
    public function createTable();
    public function save(array $data);
}