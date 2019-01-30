<?php

declare(strict_types=1);

namespace App\Repository\Domain;

use App\Entity\Domain\User;
use App\Enum\Status;
use Infrastructure\Database\Entity;
use Infrastructure\Repository\Repository;

class UserRepository extends Repository
{
    public function getEntity() : Entity
    {
        return new User();
    }

    public function authenticateUser(string $email, string $password) : array
    {
        $qb = $this->getEntityManager()->getConnection()->createQueryBuilder();
        $qb
            ->select(['*'])
            ->from($this->getEntityManager()->getTableName())
            ->where('status = :statusUser')
            ->setParameter('statusUser', Status::ACTIVE)
            ->andWhere('email = :emailUser')
            ->setParameter('emailUser', $email)
            ->andWhere('password = :passwordUser')
            ->setParameter('passwordUser', $password)
            ->setMaxResults(1);

        $user = $qb->execute()->fetch();

        return $user === false ? [] : $user;
    }
}
