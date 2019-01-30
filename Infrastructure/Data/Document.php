<?php

declare(strict_types=1);

namespace Infrastructure\Data;

abstract class Document
{
    public static function isEmail(string $value) : bool
    {
        if (filter_var($value, FILTER_VALIDATE_EMAIL)) {
            return true;
        } else {
            return false;
        }
    }

    public static function isVerifyCode(string $digit, int $positions = 10, int $sumDigits = 0) : string
    {
        for ($i = 0; $i < strlen($digit); $i++) {
            $sumDigits = $sumDigits + ( $digit[$i] * $positions );
            $positions--;
        }
        $sumDigits = $sumDigits % 11;

        if ($sumDigits < 2)
            $sumDigits = 0;
        else
            $sumDigits = 11 - $sumDigits;

        $digitValue = $digit . $sumDigits;

        return $digitValue;
    }

    public static function isCpf(string $value) : bool
    {
        $notCPF = array('11111111111', '22222222222', '33333333333',
            '44444444444', '55555555544', '66666666666',
            '77777777777', '88888888888', '99999999999');

        $value = self::integer($value);

        if (is_numeric($value)) {

            foreach ($notCPF as $val) {
                if ((string) $value == $val) {
                    return false;
                }
            }

            $newCpf = self::isVerifyCode(self::isVerifyCode(substr($value, 0, 9)), 11);

            if ($newCpf === $value) {
                return true;
            } else {
                return false;
            }
        }

        return false;
    }

    public static function isCnpj(string $value) : bool
    {
        $value = self::integer($value);

        if ($this->IsNumeric($value)) {
            $cnpjOrigin = $value;

            $cnpj = self::isVerifyCode(self::isVerifyCode(substr($cnpjOrigin, 0, 12), 5), 6);

            if ($cnpj === $cnpjOrigin) {
                return true;
            }
        }

        return false;
    }

    public static function integer(string $value) : string
    {
        return (string) preg_replace('/[^0-9]/', '', $value);
    }

    public static function isNullOrWhiteSpace(string $string) : bool
    {
        return ($string == '' || is_null($string));
    }
}
