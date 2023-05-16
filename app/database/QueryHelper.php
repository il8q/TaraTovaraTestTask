<?php

namespace App\database;

use Simplon\Mysql\QueryBuilder\ReadQueryBuilder;

class QueryHelper
{
    public static function addConditionsTo(ReadQueryBuilder &$query, array $criteria): void
    {
        foreach ($criteria as [$column, $value, $operator])
        {
            $query->addCondition($column, $value, $operator);
        }
    }

    public static function generateCriteriaString(array $criteria): string
    {
        $result = '';
        foreach ($criteria as [$column, $value, $operator])
        {
            $result .= sprintf("%s %s %s and ", $column, $operator, $value);
        }
        return substr($result, 0, strlen($result) - 4);
    }
}