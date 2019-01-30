<?php

declare(strict_types=1);

namespace App\Service\User;

use App\Entity\Domain\User;
use App\Entity\Domain\UserLogLogin;
use App\Repository\Domain\UserRepository;
use Infrastructure\Data\Cryptographer;
use Infrastructure\Data\Session;
use Infrastructure\Request\CreateRequest;

class UserService
{
    /** @var UserRepository $userRepository */
    private $userRepository;

    /** @var Session $session */
    private $session;

    public function __construct(UserRepository $userRepository, Session $session)
    {
        $this->userRepository = $userRepository;
        $this->session        = $session;
    }

    public function save(?int $userId = null, int $profileId, string $name, string $email, string $password, int $status) : int
    {
        $user = new User();

        if (!empty($userId)) {
            $user->set('id_user', $userId);
        }

        $user
            ->set('id_profile', $profileId)
            ->set('name', $name)
            ->set('email', $email)
            ->set('password', Cryptographer::hash($password))
            ->set('status', $status);

        return $user->flush();
    }

    public function getAll(array $criteria = [], array $fields = ['*']) : array
    {
        $users = $this->userRepository->findBy($criteria, $fields);

        if (!$users) {
            return [];
        }

        return $users;
    }

    public function getById(int $userId, array $fields = ['*']) : array
    {
        $user = $this->userRepository->findById($userId, $fields);

        if (!$user) {
            return [];
        }

        return $user;
    }

    public function authenticate(string $email, string $password) : bool
    {
        $user = $this->userRepository->authenticateUser($email, Cryptographer::hash($password));

        if (count($user) > 0) {
            $this->session->setAuthenticated();
            $this->session->set('user', $user);
            $this->createLogLogin((int)$user['id_user']);
            return true;
        }

        return false;
    }

    private function createLogLogin(int $userId) : void
    {
        $log = new UserLogLogin();
        $log
            ->set('id_user', $userId)
            ->set('dateLogin',date("Y-m-d H:i:s"))
            ->set('info', json_encode((new CreateRequest())->getServer()))
            ->set('id_user', $userId);

        $log->flush();
    }
}
