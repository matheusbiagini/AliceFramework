<?php

declare(strict_types=1);

namespace Infrastructure\Data;

class Errors
{
    public static function display(array $errors) : string
    {
        $message[] = "<ul>";

        foreach ($errors as $error) {
            $message[] = "<li>{$error}</li>";
        }

        $message[] = "</ul>";

        return implode("", $message);
    }
}
