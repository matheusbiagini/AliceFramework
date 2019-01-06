<?php

declare(strict_types=1);

namespace Infrastructure\Controller;

use Infrastructure\Kernel\ServiceContainer;
use Infrastructure\Response\Json;
use Infrastructure\Response\Response;
use Infrastructure\Response\TemplateEngine;

class AbstractController
{
    /** @return mixed */
    public function getService(string $serviceName)
    {
        return ServiceContainer::get($serviceName);
    }

    public function json(array $arguments = []) : Response
    {
        return new Json($arguments);
    }

    public function render(string $template, array $arguments = []) : Response
    {
        return new TemplateEngine($template, $arguments);
    }
}
