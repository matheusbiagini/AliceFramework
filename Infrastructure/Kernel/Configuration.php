<?php

declare(strict_types=1);

namespace Infrastructure\Kernel;

class Configuration
{
    /** @var bool $isEnvTest */
    private $isEnvTest;

    public function __construct(bool $isEnvTest = false)
    {
        $this->isEnvTest = $isEnvTest;
    }

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

        $envMysql = parse_ini_file($rootPath . '/Docker/env/mysql.env');

        if ($this->isEnvTest) {
            $envMysql = parse_ini_file($rootPath . '/Docker/env/mysql-test.env');
        }

        return array_merge(
            parse_ini_file($rootPath . '/Docker/env/app.env'),
            $envMysql,
            getenv()
        );
    }

    public static function getInstance(bool $isEnvTest = false) : self
    {
        return new self($isEnvTest);
    }
}
