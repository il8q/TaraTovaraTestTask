<?php

namespace App;

use Simplon\Mysql\Mysql;

class IncomeDatabaseManager implements IncomeDatabaseManagerInterface
{
    /**
     * @param Mysql $connection
     */
    public function __construct(
        Mysql $connection
    )
    {
    }

    public function get(
        array $criteria,
        int $limit = 10,
        int $offset = 0
    ): array
    {
        return [
            'headers' => ['title', 'cell'],
            'rows' => [
                ['1', '2'],
                ['2', '3'],
            ],
        ];
    }
}