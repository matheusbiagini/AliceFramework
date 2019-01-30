<?php

declare(strict_types=1);

namespace Infrastructure\Kernel;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

class DependencyInjection
{
     /**
     * @return ContainerInterface
     * @throws \Exception
     */
    public function getContainer() : ContainerInterface
    {
        $container = $this->createContainer();
        return $container;
    }

    /**
     * Getter services yml
     * @return string[]
     */
    public function getConfigContainers() : array
    {
        return [
            'Infrastructure.yml',
            'Service.yml'
        ];
    }

    private function getRootPath() : string
    {
        return str_replace(['/web'], [''], getcwd()) . '/Config';
    }

    private function createContainer() : ContainerBuilder
    {
        $containerBuilder = new ContainerBuilder();

        $loader = new YamlFileLoader($containerBuilder, new FileLocator($this->getRootPath()));

        foreach ($this->getConfigContainers() as $config) {
            $loader->load($config);
        }

        return $containerBuilder;
    }
}
