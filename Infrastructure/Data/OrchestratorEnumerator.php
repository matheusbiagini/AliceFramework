<?php

declare(strict_types=1);

namespace Infrastructure\Data;

interface OrchestratorEnumerator
{
    public function getDisplayName() : array;
}
