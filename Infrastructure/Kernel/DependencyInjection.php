<?php

declare(strict_types=1);

namespace Infrastructure\Kernel;

use Symfony\Component\Config\ConfigCache;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\Dumper\PhpDumper;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

class DependencyInjection
{
     /**
     * @return ContainerInterface
     * @throws \Exception
     */
    public function getContainer() : ContainerInterface
    {
        $container = $this->create();
        return $container;
    }

    private function create() : ContainerInterface
    {
        $containerBuilder = new ContainerBuilder();

        $loader = new YamlFileLoader($containerBuilder, new FileLocator('../Config'));
        $loader->load('Infrastructure.yml');
        $loader->load('Services.yml');

        return $containerBuilder;
    }


}
