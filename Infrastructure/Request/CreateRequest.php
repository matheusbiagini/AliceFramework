<?php

declare(strict_types=1);

namespace Infrastructure\Request;

class CreateRequest implements Request
{
    public function getParam(string $key, $default = null)
    {
        if (!isset($this->getParams()[$key])) {
            return $default;
        }

        return $this->getParams()[$key];
    }

    private function getParams() : array
    {
        return $_REQUEST;
    }
}
