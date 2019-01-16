<?php

declare(strict_types=1);

namespace Test\unit;

use Infrastructure\Kernel\ServiceContainer;
use Symfony\Component\DependencyInjection\Container;

trait TraitDependencyInjection
{
    protected function getContainer() : Container
    {
        return ServiceContainer::get();
    }
}
