<?php

declare(strict_types=1);

namespace Infrastructure\Traits;

use Infrastructure\Kernel\DependencyInjection;
use Infrastructure\Kernel\ServiceContainer;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\DependencyInjection\ContainerInterface;

trait TraitServiceContainer
{
    /** @var Container */
    private $container;

    public function createContainer() : ContainerInterface
    {
        $dependencyInjection = new DependencyInjection();
        return $dependencyInjection->getContainer();
    }

    public function getContainer() : Container
    {
        return ServiceContainer::get();
    }

    public function mockService($id, $service) : Container
    {
        $container = $this->createContainer();
        $container->set($id, $service);
        return $container;
    }
}