<?php

declare(strict_types=1);

namespace Test\unit\Infrastructure\Kernel;

use Codeception\Test\Unit;
use Infrastructure\Kernel\DependencyInjection;
use Symfony\Component\DependencyInjection\ContainerInterface;

class DependencyInjectionTest extends Unit
{
    public function getInstance() : DependencyInjection
    {
        return new DependencyInjection();
    }

    public function testShouldBeContainer() : void
    {
        $container = $this->getInstance()->getContainer();

        $this->assertInstanceOf(ContainerInterface::class, $container);
    }

    public function testShouldBeConfigs() : void
    {
        $configs = $this->getInstance()->getConfigContainers();

        $this->assertIsArray($configs);
    }
}
