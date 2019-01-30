<?php

declare(strict_types=1);

namespace App\Entity\Domain;

use Infrastructure\Database\EntityManager;

class UserLogLogin extends EntityManager
{
    public function getTableName(): string
    {
        return 'user_log_login';
    }

    public function getPrimaryKey(): string
    {
        return 'id_user_log_login';
    }
}
