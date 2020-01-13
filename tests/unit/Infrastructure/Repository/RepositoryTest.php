<?php

declare(strict_types=1);

namespace Test\unit\Infrastructure\Repository;

use App\Entity\Domain\User;
use App\Enum\Profile;
use App\Enum\Status;
use App\Repository\Domain\UserRepository;
use Infrastructure\Data\Cryptographer;
use Codeception\Test\Unit;
use Infrastructure\Repository\Repository;

class RepositoryTest extends Unit
{
    private function getInstance() : Repository
    {
        return new UserRepository();
    }

    public function testShouldFindBy() : void
    {
        $id = $this->createUserForTest();

        $repository = $this->getInstance()->findBy(['id_user' => $id], ['id_user', 'email']);

        foreach ($repository as $user) {
            $this->assertArrayHasKey('id_user', $user);
            $this->assertArrayHasKey('email', $user);
            $this->assertEquals('zezinho.teste@test.com', $user['email']);
        }

        $this->assertIsArray($repository);
    }

    public function testShouldFindById() : void
    {
        $id = $this->createUserForTest();

        $user = $this->getInstance()->findById($id);

        $this->assertArrayHasKey('id_user', $user);
        $this->assertArrayHasKey('email', $user);

        $this->assertEquals($id, $user['id_user']);
        $this->assertEquals('zezinho.teste@test.com', $user['email']);
    }

    public function testShouldFindOneBy() : void
    {
        $id = $this->createUserForTest();

        $user = $this->getInstance()->findOneBy(['id_user' => $id], ['id_user', 'email']);

        $this->assertArrayHasKey('id_user', $user);
        $this->assertArrayHasKey('email', $user);

        $this->assertEquals($id, $user['id_user']);
        $this->assertEquals('zezinho.teste@test.com', $user['email']);

        $this->assertIsArray($user);
    }

    public function testShouldFindOrBy() : void
    {
        $id1 = $this->createUserForTest();
        $name = $this->createUserForTest(true);

        $users = $this->getInstance()->findOrBy(['id_user' => $id1, 'name' => $name], ['id_user', 'name']);

        $this->assertCount(2, $users);
    }

    public function testShouldBePagination() : void
    {
        $this->createUserForTest();
        $this->createUserForTest();
        $this->createUserForTest();

        $users = $this->getInstance()->setPagination($this->getInstance()->commonQuery(), 1, 2)->execute()->fetchAll();

        $this->assertCount(2, $users);
    }

    /**
     * @param bool $returnName
     * @return int|string
     */
    private function createUserForTest(bool $returnName = false)
    {
        $name = 'Zezinho De ' . Cryptographer::generatePassword();

        /** @var User $user */
        $user = $this->getInstance()->getEntity();
        $user
            ->set('name', $name)
            ->set('email', 'zezinho.teste@test.com')
            ->set('password', Cryptographer::hash($name))
            ->set('status', Status::ACTIVE)
            ->set('id_profile', Profile::ADMIN);

        $id = $user->flush();

        return $returnName === true ? $name : $id;
    }
}
