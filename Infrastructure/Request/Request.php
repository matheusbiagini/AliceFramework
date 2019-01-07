<?php

declare(strict_types=1);

namespace Infrastructure\Request;

interface Request
{
    public function getServer() : array;
    public function getParam(string $key, $default = null);
    public function getBody() : string;
    public function getStatusCode() : int;
    public function json() : string;
}
