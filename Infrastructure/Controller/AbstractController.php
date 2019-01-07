<?php

declare(strict_types=1);

namespace Infrastructure\Controller;

use Infrastructure\Kernel\ServiceContainer;
use Infrastructure\Response\Json;
use Infrastructure\Response\Response;
use Infrastructure\Response\TemplateEngine;

class AbstractController
{
    /**
     * @param string $serviceName
     * @return mixed
     * @throws \Exception
     */
    public function getService(string $serviceName)
    {
        return ServiceContainer::get()->get($serviceName);
    }

    public function json(array $arguments = []) : Response
    {
        return new Json($arguments);
    }

    public function render(string $template, array $arguments = []) : Response
    {
        return new TemplateEngine($template, $arguments);
    }

    public function view(string $template, array $arguments = []) : string
    {
        $templateEngine = new TemplateEngine($template, $arguments, false);
        return $templateEngine->content($arguments);
    }
}
