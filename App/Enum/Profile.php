<?php

declare(strict_types=1);

namespace App\Enum;

use Infrastructure\Data\Enumerator;

class Profile extends Enumerator
{
    public const ADMIN = 1;
    public const USER = 2;

    public function getDisplayName() : array
    {
        return [
            self::ADMIN  => translate('PROFILE_ADMIN'),
            self::USER   => translate('PROFILE_USER'),
        ];
    }
}
