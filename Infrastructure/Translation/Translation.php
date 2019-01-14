<?php

declare(strict_types=1);

namespace Infrastructure\Translation;

interface Translation
{
    public function getKey() : string;
    public function translations() : array;
}
