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

    public function rootPath() : string
    {
        $rootPath = getcwd();

        if (PHP_SAPI !== 'cli') {
            $rootPath = '..';
        }

        return $rootPath;
    }

    private function getEnvironments() : array
    {
        $rootPath = $this->rootPath();

        return array_merge(
            parse_ini_file($rootPath . '/Docker/env/app.env'),
            parse_ini_file($rootPath . '/Docker/env/mysql.env'),
            getenv()
        );
    }
}
