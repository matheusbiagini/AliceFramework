<?php

declare(strict_types=1);

namespace Infrastructure\Kernel;

use Slim\Slim;

class Application
{
    private $dependencyInjection;

    public function __construct(DependencyInjection $dependencyInjection)
    {
        $this->dependencyInjection = $dependencyInjection;
    }

    public function main(string $mode = 'dev') : void
    {
        ServiceContainer::set($this->dependencyInjection->getContainer());
        $this->buildRouting();
    }

    private function buildRouting() : void
    {
        $route = new Route();
        $route->make(new Slim());
    }
}
