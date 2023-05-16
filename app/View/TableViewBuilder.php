<?php

namespace App\View;

class TableViewBuilder
{
    public function __construct(
        private string $result = '',
    )
    {
    }

    public function generateTitle(string $title): void
    {
        $this->result .= "<h2>$title</h2>";
    }

    public function generateHeaders(array $headers): void
    {
        $headerTags = "<tr>";
        foreach ($headers as $header) {
            $headerTags .= "<th>$header</th>";
        }
        $headerTags .= '</tr>';

        $this->result .= $headerTags;
    }

    public function generateRows(mixed $rows): void
    {
        $rowTags = '';
        foreach ($rows as $row) {
            $rowTags .= "<tr>";
            $rowTags .= $this->generateCells($row);
            $rowTags .= '</tr>';
        }

        $this->result .= $rowTags;
    }

    private function generateCells(mixed $row): string
    {
        $cells = '';
        foreach ($row as $cell) {
            $cells .= "<td>$cell</td>";
        }
        return $cells;
    }

    public function generateStartTableTag(): void
    {
        $this->result .= "<table>";
    }

    public function generateEndTableTag(): void
    {
        $this->result .= "</table>";
    }

    public function getResult(): string
    {
        return $this->result;
    }

    public function resetResult(): void
    {
        $this->result = '';
    }
}