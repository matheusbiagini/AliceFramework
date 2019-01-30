<?php

declare(strict_types=1);

namespace Test\App\Repository\Domain;

use App\Enum\Profile;
use App\Enum\Status;
use App\Repository\Domain\UserRepository;
use Codeception\Test\Unit;
use Infrastructure\Data\Cryptographer;
use Infrastructure\Kernel\ServiceContainer;

class UserRepositoryTest extends Unit
{
    private function getInstance() : UserRepository
    {
        return ServiceContainer::get()->get('user.repository');
    }

    private function generateUserTest(string $name, string $email, string $password, int $status = 1) : int
    {
        /** @var \App\Entity\Domain\User $user */
        $user = $this->getInstance()->getEntity();
        $user
            ->set('name', $name)
            ->set('email', $email)
            ->set('password', Cryptographer::hash($password))
            ->set('status', $status)
            ->set('id_profile', Profile::ADMIN);

        return $user->flush();
    }

    /**
     * @return mixed[]
     */
    public function dataProviderAuthenticateSuccessfully() : array
    {
        return [
            ['matheus', 'matheus.biagini@gmail.com', '123456'],
            ['dolly', 'dolly.biagini@gmail.com', '321654'],
            ['alice', 'alice.biagini@gmail.com', '142536'],
        ];
    }

    /**
     * @dataProvider dataProviderAuthenticateSuccessfully
     * @param string $name
     * @param string $email
     * @param string $password
     */
    public function testShouldAuthenticateSuccessfully(string $name, string $email, string $password) : void
    {
        $userId = $this->generateUserTest($name, $email, $password, Status::ACTIVE);

        $authenticated = $this->getInstance()->authenticateUser($email, Cryptographer::hash($password));

        $this->assertEquals($userId, $authenticated['id_user']);
    }

    public function testShouldAuthenticateUnsuccessfully() : void
    {
        $this->generateUserTest('zezinho@danado.com.br', 'zezinho@danado.com.br', '123456', Status::DISABLED);

        $authenticated = $this->getInstance()->authenticateUser('zezinho@danado.com.br', Cryptographer::hash('32121'));

        $this->assertCount(0, $authenticated);
    }
}
