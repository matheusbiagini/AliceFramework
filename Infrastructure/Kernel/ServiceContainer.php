<?php

declare(strict_types=1);

namespace Infrastructure\Kernel;

use Symfony\Component\DependencyInjection\Container;

abstract class ServiceContainer
{
    public static $SERVICE_CONTAINER;
    public static $CONFIGURATION;

    public static function set(Container $container) : void
    {
        self::$SERVICE_CONTAINER = $container;
    }

    public static function get() : Container
    {
        return self::$SERVICE_CONTAINER;
    }

    public static function setConfiguration(Configuration $configuration) : void
    {
        self::$CONFIGURATION = $configuration;
    }

    public static function getConfiguration() : Configuration
    {
        return self::$CONFIGURATION;
    }
}
