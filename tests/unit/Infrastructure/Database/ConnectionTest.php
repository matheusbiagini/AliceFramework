<?php

declare(strict_types=1);

namespace Test\unit\Infrastructure\Database;

use Codeception\Test\Unit;
use Infrastructure\Database\Connection;

class ConnectionTest extends Unit
{
    public function testShouldBeADbalConnection() : void
    {
        $connection = Connection::getInstance();
        $this->assertInstanceOf(\Doctrine\DBAL\Connection::class, $connection->getConnection());
    }

    public function testShouldABeInstanceOfPdo() : void
    {
        $connection = Connection::getInstance();
        $this->assertInstanceOf(\PDO::class, $connection->getPdo());
    }

    public function testShouldBeIdentifier() : void
    {
        $connection = Connection::getInstance();
        $this->assertIsString($connection->identifier());
    }
}
