<?php

declare(strict_types=1);

namespace App\Enum;

use Infrastructure\Data\Enumerator;

class Status extends Enumerator
{
    public const EXCLUDED = 0;
    public const ACTIVE = 1;
    public const DISABLED = 2;
}
