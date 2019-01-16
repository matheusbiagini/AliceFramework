<?php

declare(strict_types=1);

namespace Test\unit\Infrastructure\Data;

use Codeception\Test\Unit;
use Infrastructure\Data\Cookie;
use Infrastructure\Kernel\ServiceContainer;

class CookieTest extends Unit
{
    private function getInstance() : Cookie
    {
        return ServiceContainer::get()->get('cookie');
    }

    public function testShouldBeCookie() : void
    {
        $this->assertInstanceOf(Cookie::class, $this->getInstance());
    }

    public function testShouldSetterAndGetterCookies() : void
    {
        $this->getInstance()->set('CookieTest', '');
        $this->assertEquals(null, $this->getInstance()->get('CookieTest'));
    }

    public function testShouldBeAllCookies() : void
    {
        $cookies = $this->getInstance()->getAll();
        $this->assertEquals([], $cookies);
    }
}
