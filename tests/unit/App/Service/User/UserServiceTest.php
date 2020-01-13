<?php

declare(strict_types=1);

namespace Test\App\Service\User;

use App\Enum\Profile;
use App\Enum\Status;
use App\Service\User\UserService;
use Codeception\Test\Unit;
use Infrastructure\Traits\TraitServiceContainer;

class UserServiceTest extends Unit
{
    use TraitServiceContainer;

    private function getInstance() : UserService
    {
        return $this
            ->mockService('email', $this->make($this->getContainer()->get('email'), ['send' => function () { return true; }]))
            ->get('user.service');
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
        $user = $this->getInstance()->save(
            null,
            Profile::ADMIN,
            'teste',
            'teste@teste.com',
            '123',
            Status::ACTIVE
        );

        $userId = $user['userId'];

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
            )['userId'],
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
        $user = $this->getInstance()->save(
            null,
            Profile::ADMIN,
            'teste',
            'teste@teste.com',
            '123',
            Status::ACTIVE
        );

        $userId = $user['userId'];

        $user = $this->getInstance()->getById($userId);

        $this->assertEquals($userId, (int)$user['id_user']);
        $this->assertEquals('teste', $user['name']);
        $this->assertEquals('teste@teste.com', $user['email']);
    }

    public function testShouldExecuteForgotPasswordSuccessfully() : void
    {
        $this->getInstance()->save(
            null,
            Profile::ADMIN,
            'teste',
            'teste@teste.com',
            '123',
            Status::ACTIVE
        );

        $originEmailService = $this->getContainer()->get('email');

        $forgot = $this->getInstance()->forgotPassword('teste@teste.com');

        $this->assertTrue($forgot);
    }
}
