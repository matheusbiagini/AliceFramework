<?php

declare(strict_types=1);

namespace Test\App\Service\User;

use App\Enum\Profile;
use App\Enum\Status;
use App\Service\User\UserService;
use Codeception\Test\Unit;
use Infrastructure\Kernel\ServiceContainer;

class UserServiceTest extends Unit
{
    private function getInstance() : UserService
    {
        return ServiceContainer::get()->get('user.service');
    }

    public function testShouldTestAuthenticationSuccessfullyAndUnsuccessfully() : void
    {
        $this->getInstance()->save(
            null,
            Profile::ADMIN,
            'teste',
            'teste@teste.com',
            '123',
            Status::ACTIVE
        );

        $this->assertTrue(
            $this->getInstance()->authenticate('teste@teste.com','123')
        );

        $this->assertFalse(
            $this->getInstance()->authenticate('fake@teste.com','fake')
        );
    }

    public function testShouldSaveUserSuccessfully() : void
    {
        #new
        $userId = $this->getInstance()->save(
            null,
            Profile::ADMIN,
            'teste',
            'teste@teste.com',
            '123',
            Status::ACTIVE
        );

        $this->assertIsInt($userId);
        $this->assertTrue($userId > 0);

        #update
        $this->assertEquals(
            $this->getInstance()->save(
                $userId,
                Profile::ADMIN,
                'teste',
                'teste@teste.com',
                '123',
                Status::ACTIVE
            ),
            $userId
        );
    }

    public function testShouldBringAllUsers() : void
    {
        $this->getInstance()->save(
            null,
            Profile::ADMIN,
            'teste',
            'teste@teste.com',
            '123',
            Status::ACTIVE
        );

        $this->getInstance()->save(
            null,
            Profile::ADMIN,
            'teste2',
            'teste2@teste.com',
            '123',
            Status::ACTIVE
        );

        $users = $this->getInstance()->getAll();

        $this->assertTrue(count($users) > 1);
    }

    public function testShouldGetUserById() : void
    {
        $userId = $this->getInstance()->save(
            null,
            Profile::ADMIN,
            'teste',
            'teste@teste.com',
            '123',
            Status::ACTIVE
        );

        $user = $this->getInstance()->getById($userId);

        $this->assertEquals($userId, (int)$user['id_user']);
        $this->assertEquals('teste', $user['name']);
        $this->assertEquals('teste@teste.com', $user['email']);
    }
}
