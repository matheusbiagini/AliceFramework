<?php

declare(strict_types=1);


namespace Infrastructure\Kernel;

use Symfony\Component\DependencyInjection\Container;

abstract class ServiceContainer
{
    public static $SERVICE_CONTAINER;

    public static function set(Container $container) : void
    {
        self::$SERVICE_CONTAINER = $container;
    }

    public static function get() : Container
    {
        return self::$SERVICE_CONTAINER;
    }
}
