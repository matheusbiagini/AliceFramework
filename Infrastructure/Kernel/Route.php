<?php

declare(strict_types=1);

namespace Infrastructure\Kernel;

use Symfony\Component\Yaml\Parser;
use Slim\Slim;

class Route
{
    /** @var mixed[] $routes */
    private $routes;

    private function extractRoutes() : void
    {
        $this->setRoutes(
            (new Parser())->parse(file_get_contents('Config/Route.yml'))
        );
    }

    private function setRoutes(array $routes) : void
    {
        $this->routes = $routes;
    }

    private function getRoutes() : array
    {
        return $this->routes;
    }

    public function make(Slim $slim) : void
    {
        $this->extractRoutes();
        $routes = $this->getRoutes()['routes'];

        foreach ($routes as $key => $route) {
            foreach ($route['method'] as $method) {
                $method = (string) strtolower($method);
                $slim
                    ->{$method}((string)$route['url'], $route['controller'].':'.$route['action.result'])
                    ->via(strtoupper($method))
                    ->name((string) $route['name']);
            }
        }
    }
}
