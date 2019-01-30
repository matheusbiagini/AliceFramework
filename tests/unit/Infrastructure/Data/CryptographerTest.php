<?php

declare(strict_types=1);

namespace Test\unit\Infrastructure\Data;

use Codeception\Test\Unit;
use Infrastructure\Data\Cryptographer;

class CryptographerTest extends Unit
{
    public function testShouldGenerateHash() : void
    {
        $hash = Cryptographer::hash('alice');
        $this->assertIsString($hash);
        $this->assertNotEquals('alice', $hash);
    }

    public function testShouldGeneratePassword() : void
    {
        $password = Cryptographer::generatePassword(10);
        $this->assertIsString($password);
        $this->assertEquals(10, strlen($password));
    }

    public function testShouldSaltIsString() : void
    {
        $salt = Cryptographer::salt();
        $this->assertIsString($salt);
    }
}
