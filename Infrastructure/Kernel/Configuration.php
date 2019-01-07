<?php

declare(strict_types=1);

namespace Infrastructure\Kernel;

class Configuration
{
    /**
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public function get(string $key, $default = false)
    {
        $environments = $this->getEnvironments();

        if (isset($environments[$key])) {
            return $environments[$key];
        }

        return $default;
    }

    private function getEnvironments() : array
    {
        return array_merge(
            parse_ini_file('../Docker/env/app.env'),
            parse_ini_file('../Docker/env/mysql.env'),
            getenv()
        );
    }
}