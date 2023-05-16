<?php

namespace App\database;

class QueryHelper
{
    public static function generateCriteriaString(array $criteria): string
    {
        $result = '';
        foreach ($criteria as $key => $value)
        {
            $result .= sprintf("%s = %s,", $key, $value);
        }
        return substr($result, 0, strlen($result) - 1);
    }

    public static function generateOrderString(array $order): string
    {
        $result = '';
        foreach ($order as $key => $value)
        {
            $result .= sprintf("%s %s,", $key, $value);
        }
        return substr($result, 0, strlen($result) - 1);
    }
}