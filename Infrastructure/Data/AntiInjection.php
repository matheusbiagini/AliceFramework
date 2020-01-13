<?php

declare(strict_types=1);

namespace Infrastructure\Data;

abstract class AntiInjection
{
    public static function sanitize($text)
    {
        if (get_magic_quotes_gpc()) {
            //Remove slashes that were used to escape characters in post.
            $text = stripslashes($text);
        }

        //Remove ALL HTML tags to prevent XSS and abuse of the system.
        $text = strip_tags($text);

        //Remove SQL Injection
        $text = self::sanitizeSql($text);

        return $text;
    }

    private static function sanitizeSql($text)
    {
        $words = [
            "INSERT ",
            "UPDATE ",
            "SELECT ",
            " OR ",
            " AND ",
            "OR 1=1",
            "\/",
            "<script>",
            "<\/script>",
            "();",
            " INTO ",
        ];

        foreach ($words as $word) {
            if (strpos(strtoupper($text), $word) !== false) {
                return '';
            }
        }

        return $text;
    }
}