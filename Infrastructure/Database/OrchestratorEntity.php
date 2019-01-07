<?php

declare(strict_types=1);

namespace Infrastructure\Database;

use Doctrine\DBAL\Connection;

abstract class OrchestratorEntity
{
    /** @var mixed[] */
    protected $fieldsCollection;

    protected static $CONNECTION_INSTANCE;

    /** return dbal instance */
    public function getConnection() : Connection
    {
        return \Infrastructure\Database\Connection::getInstance()
            ->getConnection();
    }

    /**
     * @param string $field
     * @param mixed $value
     * @return EntityManager
     */
    public function set(string $field, $value) : self
    {
        $this->fieldsCollection[$field] = $value;
        return $this;
    }

    public function insert() : int
    {
        $connection = $this->getConnection();

        $connection->insert($this->getTableName(), $this->fieldsCollection);

        $this->reset();

        return (int) $connection->lastInsertId();
    }

    public function update(string $criteria = "") : int
    {
        $criteria = empty($criteria) ? [$this->getPrimaryKey() => $this->fieldsCollection[$this->getPrimaryKey()]] : $criteria;

        $this->getConnection()
            ->update(
                $this->getTableName(),
                $this->fieldsCollection,
                $criteria
            );

        $this->reset();

        return (int) $this->fieldsCollection[$this->getPrimaryKey()];
    }

    public function flush() : int
    {
        if (!empty($this->fieldsCollection[$this->getPrimaryKey()])) {
            return $this->update();
        } else {
            return $this->insert();
        }
    }

    public function reset() : self
    {
        $this->fieldsCollection = [];
        return $this;
    }
}
