<?php

declare(strict_types=1);

namespace Test\unit\Infrastructure\Kernel;

use Codeception\Test\Unit;
use Infrastructure\Data\Cookie;
use Infrastructure\Data\Session;
use Infrastructure\Kernel\DependencyInjection;
use Infrastructure\Kernel\ServiceContainer;

class ServiceContainerTest extends Unit
{
    public function testMustRegisterContainer() : void
    {
        ServiceContainer::set((new DependencyInjection())->getContainer());
        $session = ServiceContainer::get()->get('session');
        $this->assertInstanceOf(Session::class, $session);
    }

    /**
     * @dataProvider servicesProvider
     * @param string $serviceName
     * @param string $instanceOf
     * @throws \Exception
     */
    public function testShouldGetDesiredService(string $serviceName, string $instanceOf) : void
    {
        $service = ServiceContainer::get()->get($serviceName);
        $this->assertInstanceOf($instanceOf, $service);
    }

    public function servicesProvider() : array
    {
        return [
            ['session', Session::class],
            ['cookie', Cookie::class],
        ];
    }
}
