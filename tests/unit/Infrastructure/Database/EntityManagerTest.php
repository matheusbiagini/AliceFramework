<?php

declare(strict_types=1);

namespace Test\unit\Infrastructure\Database;

use App\Entity\Domain\User;
use App\Enum\Profile;
use App\Enum\Status;
use Infrastructure\Data\Cryptographer;
use Codeception\Test\Unit;
use Doctrine\DBAL\Connection;
use Infrastructure\Database\EntityManager;

class EntityManagerTest extends Unit
{
    private function getInstance() : EntityManager
    {
        return new User();
    }

    public function testShouldBeADbalConnection() : void
    {
        $connection = $this->getInstance()->getConnection();
        $this->assertInstanceOf(Connection::class, $connection);
    }

    public function testShouldBePrimaryKeyAndTableName() : void
    {
        $entityManager = $this->getInstance();
        $this->assertIsString($entityManager->getPrimaryKey());
        $this->assertIsString($entityManager->getTableName());
    }

    public function testEntityMustPersist() : void
    {
        $entityManager = $this->getInstance();

        $userId = $entityManager
            ->set('name', 'zezinho')
            ->set('email', 'zezinho@teste.com')
            ->set('password', Cryptographer::hash('abelinha123'))
            ->set('status', Status::ACTIVE)
            ->set('id_profile', Profile::ADMIN)
            ->flush();

        $this->assertIsInt($userId);
    }

    public function testShouldInsertAndUpdateSuccessfully() : void
    {
        $entityManager = $this->getInstance();

        $userId = $entityManager
            ->set('name', 'zezinho insert')
            ->set('email', 'zezinho@teste.com')
            ->set('password', Cryptographer::hash('abelinha123'))
            ->set('status', Status::ACTIVE)
            ->set('id_profile', Profile::ADMIN)
            ->insert();

        $this->assertIsInt($userId);

        $entityManager
            ->set($entityManager->getPrimaryKey(), $userId)
            ->set('name', 'zezinho update')
            ->update();

        $query = "SELECT name FROM %s WHERE %s = %s";

        $name = $entityManager->getConnection()
                   ->fetchColumn(sprintf($query, $entityManager->getTableName(), $entityManager->getPrimaryKey(), $userId));

        $this->assertEquals('zezinho update', $name);
    }
}
