<?php

declare(strict_types=1);

namespace Infrastructure\Kernel;

use Infrastructure\Request\CreateRequest;
use Symfony\Component\Yaml\Parser;
use Slim\Slim;

class Route
{
    /** @var mixed[] $routes */
    private $routes;

    public function __construct()
    {
        $this->extract();
    }

    public static function url(string $routeName, array $params = []) : string
    {
        $self = new self();

        foreach ($self->getRoutes()['routes'] as $route) {
            if ($route['name'] === $routeName) {
                if (count($params) === 0) {
                    return $route['url'];
                }

                return $route['url'] . '?' . http_build_query($params);
            }
        }

        return '';
    }

    public static function getUrlAll() : array
    {
        $self = new self();
        return $self->getRoutes()['routes'] ?? [];
    }

    public function make(Slim $slim) : Slim
    {
        foreach ($this->getRoutes()['routes'] as $route) {
            foreach ($route['method'] as $method) {
                $request = new CreateRequest($slim);
                $method  = (string) strtolower($method);
                $slim
                    ->{$method}((string)$route['url'], function() use ($route, $request) {
                        $controller = new $route['controller']($request, $route['action.result']);
                        $controller->{$route['action.result']}($request);
                    })
                    ->via(strtoupper($method))
                    ->name((string) $route['name']);
            }
        }



        $slim->run();

        return $slim;
    }

    private function extract() : void
    {
        $this->setRoutes(
            (new Parser())->parse(file_get_contents(self::getPathRoutes()))
        );
    }

    private function setRoutes(array $routes) : void
    {
        $this->routes = $routes;
    }

    public function getRoutes() : array
    {
        return $this->routes;
    }

    private static function getPathRoutes() : string
    {
        return PATH_ROOT . '/Config/Route.yml';
    }
}
