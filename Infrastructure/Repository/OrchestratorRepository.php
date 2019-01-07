<?php

declare(strict_types=1);

namespace Infrastructure\Repository;

use Doctrine\DBAL\Query\QueryBuilder;
use Infrastructure\Database\EntityManager;

abstract class OrchestratorRepository
{
    /** @var mixed[] $orderBy */
    protected $orderBy = [];

    protected function getEntityManager() : EntityManager
    {
        return $this->getEntity();
    }

    public function commonQuery(array $criteria = [], array $fields = ['*'], $limit = null, $offset = null) : QueryBuilder
    {
        /** @var QueryBuilder $qb */
        $qb = $this->getEntityManager()->getConnection()->createQueryBuilder();

        $qb->select($fields)->from($this->getEntityManager()->getTableName());

        if(!empty($limit)) {
            $qb->setMaxResults($limit);
        }

        if(!empty($offset)) {
            $qb->setFirstResult($offset);
        }

        return $qb;
    }

    public function findById(int $id, array $fields = ['*'])
    {
        $qb = $this->commonQuery([], $fields);
        $primaryKey = $this->getEntityManager()->getPrimaryKey();
        $qb->where("$primaryKey = :id")->setParameter('id', $id);

        return $qb->execute()->fetch();
    }

    public function findBy(array $criteria = [], array $fields = ['*'], $limit = null, $offset = null)
    {
        $qb = $this->commonQuery($criteria, $fields, $limit, $offset);

        foreach($criteria as $key => $condition) {
            $qb->AndWhere("{$key} = :{$key}")->setParameter($key, $condition);
        }

        foreach ($this->orderBy as $order) {
            $qb->addOrderBy($order['key'], $order['order']);
        }

        return $qb->execute()->fetchAll();
    }

    public function findOneBy(array $criteria = [], array $fields = ['*'], $limit = null, $offset = null)
    {
        $qb = $this->commonQuery($criteria, $fields, $limit, $offset);

        foreach($criteria as $key => $condition) {
            $qb->AndWhere("{$key} = :{$key}")->setParameter($key, $condition);
        }

        foreach ($this->orderBy as $order) {
            $qb->addOrderBy($order['key'], $order['order']);
        }

        return $qb->execute()->fetch();
    }

    public function findOrBy(array $criteria = [], array $fields = ['*'], $limit = null, $offset = null)
    {
        $qb = $this->commonQuery($criteria, $fields, $limit, $offset);

        foreach($criteria as $key => $condition) {
            $qb->orWhere("{$key} = :{$key}")->setParameter($key, $condition);
        }

        foreach ($this->orderBy as $order) {
            $qb->addOrderBy($order['key'], $order['order']);
        }

        return $qb->execute()->fetchAll();
    }

    public function setOrderBy(string $key, string $ascOrDesc = "asc") : self
    {
        $this->orderBy[] = ['key' => $key, 'order' => $ascOrDesc];
        return $this;
    }

    public function setPagination(QueryBuilder $qb, int $limit, int $offset) : QueryBuilder
    {
        return $qb->setFirstResult($offset)->setMaxResults($limit);
    }

    protected function createPagination(QueryBuilder $qb, int $totalPerPage) : array
    {
        $countQb = clone $qb;
        $countQb->select('count(1) as tt_result');
        $totalResult = $countQb->execute()->fetchColumn();

        return [
            'total' => $totalResult,
            'totalPages' => (int) round($totalResult / $totalPerPage),
            'totalPerPage' => $totalPerPage,
        ];
    }
}
