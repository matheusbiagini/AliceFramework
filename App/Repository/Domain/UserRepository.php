<?php

declare(strict_types=1);

namespace App\Repository\Domain;

use App\Entity\Domain\User;
use Infrastructure\Database\Entity;
use Infrastructure\Repository\Repository;

class UserRepository extends Repository
{
    public function getEntity() : Entity
    {
        return new User();
    }
}
