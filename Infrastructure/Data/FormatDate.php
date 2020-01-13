<?php

declare(strict_types=1);

namespace Infrastructure\Data;

abstract class FormatDate
{
    public static function format(?string $date, string $type = "PT"): string
    {
        $value = preg_replace('/[^0-9]/', '', $date);

        if (!is_numeric($value)) {
            return '';
        }

        switch (strtoupper($type)) {
            case 'PT':
            case 'BR':
                $data[] = substr($value, 6, 2) . '/';
                $data[] = substr($value, 4, 2) . '/';
                $data[] = substr($value, 0, 4);

                if (strlen($value) > 10) {

                    $data[] = ' ';
                    $data[] = substr($value, 8, 2) . ':';
                    $data[] = substr($value, 10, 2) . ':';
                    $data[] = substr($value, 12, 2);
                }

                return implode("", $data);
                break;
            case 'US':
            case 'EN':
                $data[] = substr($value, 4, 4) . '-';
                $data[] = substr($value, 2, 2) . '-';
                $data[] = substr($value, 0, 2);

                if (strlen($value) > 10) {
                    $data[] = ' ';
                    $data[] = substr($value, 8, 2) . ':';
                    $data[] = substr($value, 10, 2) . ':';
                    $data[] = substr($value, 12, 2);
                }

                return implode("", $data);
                break;
        }

        return '';
    }

    public static function isValidDate($date, $format = 'Y-m-d H:i:s') : bool
    {
        if (empty($date) || strtolower($date) === 'null') {
            return false;
        }

        $d = \DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) == $date;
    }
}
