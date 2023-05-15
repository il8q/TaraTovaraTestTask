<?php

namespace App;

class TableViewGenerator
{
    public static function generate(array $table): string
    {
        $result = "<table>";
        $result .= self::generateHeaders($table['headers']);
        $result .= self::generateRows($table['rows']);
        $result .= '</table>';
        return $result;
    }

    private static function generateHeaders(array $headers): string
    {
        $result = "<tr>";
        foreach ($headers as $header) {
            $result .= "<th>$header</th>";
        }
        $result .= '</tr>';
        return $result;
    }

    private static function generateRows(mixed $rows): string
    {
        $result = '';
        foreach ($rows as $row) {
            $result .= "<tr>";
            $result .= self::generateCells($row);
            $result .= '</tr>';
        }
        return $result;
    }

    private static function generateCells(mixed $row): string
    {
        $result = '';
        foreach ($row as $cell) {
            $result .= "<td>$cell</td>";
        }
        return $result;
    }
}