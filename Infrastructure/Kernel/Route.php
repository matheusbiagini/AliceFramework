<?php

declare(strict_types=1);

namespace Infrastructure\Kernel;

use Symfony\Component\Yaml\Parser;
use Slim\Slim;

class Route
{
    /** @var string  */
    private const ROUTE_PATH = '../Config/Route.yml';

    /** @var mixed[] $routes */
    private $routes;

    public function __construct()
    {
        $this->extract();
    }

    public function make(Slim $slim) : void
    {
        foreach ($this->getRoutes()['routes'] as $route) {
            $gateway = $route['controller'].':'.$route['action.result'];
            foreach ($route['method'] as $method) {
                $method = (string) strtolower($method);
                $slim
                    ->{$method}((string)$route['url'], $gateway)
                    ->via(strtoupper($method))
                    ->name((string) $route['name']);
            }
        }

        $slim->run();
    }

    private function extract() : void
    {
        $this->setRoutes(
            (new Parser())->parse(file_get_contents(self::ROUTE_PATH))
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
}
