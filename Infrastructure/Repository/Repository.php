<?php

declare(strict_types=1);

namespace Infrastructure\Repository;

use Infrastructure\Database\Entity;

abstract class Repository extends OrchestratorRepository
{
    public abstract function getEntity() : Entity;
}
