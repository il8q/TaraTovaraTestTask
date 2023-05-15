<?php

namespace App;

class PageGenerator
{
    public static function renderHtml(string $title, string $body): string
    {
        $result = '<!DOCTYPE HTML>';
        $result .= '<html>';
        if ($title) {
            $result .= "<h1>$title</h1>";
        }
        if ($body) {
            $result .= "<body>$body</body>";
        }
        $result .= '</html>';
        return $result;
    }
}