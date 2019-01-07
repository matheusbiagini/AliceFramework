<?php

declare(strict_types=1);

namespace App\Service\User;

use App\Entity\Domain\User;
use App\Repository\Domain\UserRepository;

class UserService
{
    /** @var UserRepository $userRepository */
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function create(int $profileId, string $name, string $email, string $password, int $status) : int
    {
        $user = new User();
        $user
            ->set('id_profile', $profileId)
            ->set('name', $name)
            ->set('email', $email)
            ->set('password', $password)
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
}
