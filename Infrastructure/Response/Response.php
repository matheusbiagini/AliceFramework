<?php

declare(strict_types=1);

namespace Infrastructure\Response;

interface Response
{
    public function render(array $arguments = []) : void;
}
