<?php

declare(strict_types=1);

namespace Infrastructure\Response;

class TemplateEngine implements Response
{
    public function __construct(string $template, array $arguments = [])
    {
    }
}
