<?php

declare(strict_types=1);

namespace Infrastructure\Request;

interface Request
{
    public function getParam(string $key, $default = null);
}
