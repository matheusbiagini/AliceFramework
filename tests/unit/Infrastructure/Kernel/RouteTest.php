<?php

declare(strict_types=1);

namespace Test\unit\Infrastructure\Kernel;

use Codeception\Test\Unit;
use Infrastructure\Kernel\Route;

class RouteTest extends Unit
{
    public function getInstance() : Route
    {
        return new Route();
    }

    public function testShouldBeRoutes() : void
    {
        $routes = $this->getInstance()->getRoutes();
        $this->assertIsArray($routes);
        $this->assertArrayHasKey('routes', $routes);
        $this->assertArrayHasKey('name', $routes['routes'][0]);
        $this->assertArrayHasKey('url', $routes['routes'][0]);
        $this->assertArrayHasKey('controller', $routes['routes'][0]);
        $this->assertArrayHasKey('action.result', $routes['routes'][0]);
        $this->assertArrayHasKey('method', $routes['routes'][0]);
    }

    public function testShouldGetUrl() : void
    {
        $url = Route::url('test');
        $this->assertEquals('/teste', $url);
    }
}
