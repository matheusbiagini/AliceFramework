<?php

declare(strict_types=1);

namespace Test\unit\Infrastructure\Kernel;

use Codeception\Test\Unit;
use Infrastructure\Kernel\Configuration;
use Infrastructure\Kernel\ServiceContainer;

class ConfigurationTest extends Unit
{
    public function getInstance() : Configuration
    {
        return ServiceContainer::getConfiguration();
    }

    public function testShouldBeRootPath() : void
    {
        $rootPath = $this->getInstance()->rootPath();
        $this->assertIsString($rootPath);
    }

    public function testShouldBeGetters() : void
    {
        $mode = $this->getInstance()->get('MODE');
        $database = $this->getInstance()->get('MYSQL_DATABASE');

        $this->assertIsString($mode);
        $this->assertEquals('dev', strtolower($mode));

        $this->assertIsString($database);
        $this->assertEquals('local_test', $database);
    }
}
