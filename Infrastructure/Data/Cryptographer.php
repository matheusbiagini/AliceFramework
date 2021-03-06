<?php

declare(strict_types=1);

namespace Infrastructure\Data;

use Infrastructure\Kernel\Configuration;

abstract class Cryptographer
{
    public static function hash(string $code) : string
    {
        return md5(md5($code).md5(self::salt()));
    }

    public static function salt() : string
    {
        return (string)Configuration::getInstance()->get('SECRET');
    }

    public static function generatePassword(int $length = 7, bool $upper = true, bool $lower = true, bool $numbers = true, bool $symbols = true) : string
    {
        $ma = "ABCDEFGHIJKLMNOPQRSTUVYXWZ"; // $ma contem as letras maiúsculas
        $mi = "abcdefghijklmnopqrstuvyxwz"; // $mi contem as letras minusculas
        $nu = "0123456789"; // $nu contem os números
        $si = "!@#"; // $si contem os símbolos
        $password = "";

        if ($upper) {
            // se $upper for "true", a variável $ma é embaralhada e adicionada para a variável $password
            $password .= str_shuffle($ma);
        }

        if ($lower) {
            // se $lower for "true", a variável $mi é embaralhada e adicionada para a variável $password
            $password .= str_shuffle($mi);
        }

        if ($numbers) {
            // se $numbers for "true", a variável $nu é embaralhada e adicionada para a variável $password
            $password .= str_shuffle($nu);
        }

        if ($symbols) {
            // se $symbols for "true", a variável $si é embaralhada e adicionada para a variável $password
            $password .= str_shuffle($si);
        }

        // retorna a senha embaralhada com "str_shuffle" com o tamanho definido pela variável $length
        return substr(str_shuffle($password),0,$length);
    }

    public static function isInThePasswordPolicy(string $password) : bool
    {
        return preg_match('/[a-z]/', $password) // tem pelo menos uma letra minúscula
            && preg_match('/[A-Z]/', $password) // tem pelo menos uma letra maiúscula
            && preg_match('/[0-9]/', $password) // tem pelo menos um número
            && preg_match('/^[\w$@]{6,}$/', $password); // tem 6 ou mais caracteres
    }
}
