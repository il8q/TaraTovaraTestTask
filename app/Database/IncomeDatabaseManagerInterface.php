<?php

namespace App\Database;

interface IncomeDatabaseManagerInterface
{
    public function createTable();
    public function save(array $data);
    public function find(
        array $params,
        ?int $limit = null,
        ?int $offset = null,
    ): array;
    public function findAndSegment(array $params): array;
}