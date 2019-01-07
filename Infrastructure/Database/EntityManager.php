<?php

declare(strict_types=1);

namespace Infrastructure\Database;

abstract class EntityManager extends OrchestratorEntity implements Entity
{
    public abstract function getTableName() : string;

    public abstract function getPrimaryKey() : string;
}
