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

    public function findByEmailAndStatusActive(string $email) : array
    {
        $qb = $this->getEntityManager()->getConnection()->createQueryBuilder();
        $qb
            ->select(['*'])
            ->from($this->getEntityManager()->getTableName())
            ->where('status = :statusUser')
            ->setParameter('statusUser', Status::ACTIVE)
            ->andWhere('email = :emailUser')
            ->setParameter('emailUser', $email)
            ->setMaxResults(1);

        $user = $qb->execute()->fetch();

        return $user === false ? [] : $user;
    }

    public function listUsersActive(?string $filter, int $page, int $totalPerPage) : array
    {
        $qb = $this->getEntityManager()->getConnection()->createQueryBuilder();
        $qb
            ->select(['*'])
            ->from($this->getEntityManager()->getTableName())
            ->where('status = :statusUser')
            ->setParameter('statusUser', Status::ACTIVE)
            ->orderBy('name', 'asc');

        if (!empty($filter)) {
            $qb->andWhere("email like '%" . $filter . "%' OR name like '%" . $filter . "%'");
        }

        $pagination = $this->createPagination($qb, $totalPerPage);

        $qb = $this->setPagination($qb, $page, $totalPerPage);

        $users = $qb->execute()->fetchAll();

        return ['users' => $users === false ? [] : $users, 'pagination' => $pagination];
    }
}
