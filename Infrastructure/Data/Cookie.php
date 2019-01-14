<?php

declare(strict_types=1);

namespace Infrastructure\Data;

class Cookie
{
    /**
     * @param string $key
     * @param mixed $value
     * @param int $lifetime
     * @return Cookie
     */
    public function set(string $key, $value, int $lifetime = 86400) : self
    {
        setcookie($key, $value,time() + $lifetime);
        return $this;
    }

    /**
     * @param string $key
     * @return mixed
     */
    public function get(string $key)
    {
        return $_COOKIE[$key] ?? null;
    }

    public function getAll() : array
    {
        return $_COOKIE;
    }

    public function destroy(?string $key = null) : void
    {
        if ($key === null) {
            unlink($_COOKIE);
        }

        unlink($_COOKIE[$key]);
    }

    public static function cookie() : self
    {
        return new self();
    }
}
