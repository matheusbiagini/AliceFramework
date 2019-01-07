<?php

declare(strict_types=1);

namespace App\Service\User;

use App\Entity\Domain\User;

class UserService
{
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
}
