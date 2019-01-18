<?php

declare(strict_types=1);

namespace Test\unit\Infrastructure\Kernel;

use Codeception\Test\Unit;
use Infrastructure\Kernel\Application;
use Infrastructure\Kernel\DependencyInjection;

class ApplicationTest extends Unit
{
    public function getInstance() : Application
    {
        return new Application(new DependencyInjection());
    }

    public function testMustHaveApplicationMain() : void
    {
        $this->assertInstanceOf(Application::class, $this->getInstance());
    }
}
