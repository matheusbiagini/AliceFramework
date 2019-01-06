<?php

declare(strict_types=1);


namespace Infrastructure\Kernel;

use Symfony\Component\DependencyInjection\ContainerInterface;

abstract class ServiceContainer
{
    public static $SERVICE_CONTAINER;

    public static function set(Container $container) : void
    {
        self::$SERVICE_CONTAINER = $container;
    }

    public static function get() : ContainerInterface
    {
        return self::$SERVICE_CONTAINER;
    }
}
