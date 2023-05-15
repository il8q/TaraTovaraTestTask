<?php

namespace App;

class PageGenerator
{
    public static function renderPage(string $title, string $body): string
    {
        $result = '<!DOCTYPE HTML>';
        $result .= '<html>';
        $result .= self::generateHeader($title);
        $result .= self::generateBody($body, $title);
        $result .= '</html>';
        return $result;
    }

    /**
     * @param string $result
     * @param string $title
     * @return string
     */
    public static function generateHeader(?string $title): string
    {
        $result = '<head>';
        if ($title) {
            $result .= "<title>$title</title>";
        }
        $result .= '</head>';
        return $result;
    }

    /**
     * @param string $body
     * @param string $title
     * @param string $result
     * @return string
     */
    public static function generateBody(?string $body, ?string $title): string
    {
        $result = '';
        if ($body) {
            if ($title) {
                $result .= "<h1>$title</h1>";
            }
            $result .= "<body>$body</body>";
        }
        return $result;
    }
}