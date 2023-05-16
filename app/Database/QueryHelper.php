<?php

namespace App\Database;

class QueryHelper
{
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