<?php

declare(strict_types=1);

namespace App\Entity\Domain;

use Infrastructure\Database\EntityManager;

class User extends EntityManager
{
    public function getTableName(): string
    {
        return 'user';
    }

    public function getPrimaryKey(): string
    {
        return 'id_user';
    }
}
