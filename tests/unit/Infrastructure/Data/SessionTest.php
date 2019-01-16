<?php

declare(strict_types=1);

namespace Test\unit\Infrastructure\Data;

use Codeception\Test\Unit;
use Infrastructure\Data\Session;
use Infrastructure\Kernel\ServiceContainer;

class SessionTest extends Unit
{
    public function getInstance() : Session
    {
        return ServiceContainer::get()->get('session');
    }

    public function testShouldBeSession() : void
    {
        $this->assertInstanceOf(Session::class, $this->getInstance());
    }

    public function testShouldBeSetterAndGetter() : void
    {
        $this->getInstance()->set('test', 'test');
        $this->assertEquals('test', $this->getInstance()->get('test'));
        $this->getInstance()->destroy();
    }

    public function testShouldDestroySessionSuccessfully() : void
    {
        $this->getInstance()->set('test', 'test');
        $this->getInstance()->destroy(false);
        $this->assertEquals(null, $this->getInstance()->get('test'));
    }
}
