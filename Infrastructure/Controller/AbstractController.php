<?php

declare(strict_types=1);

namespace Infrastructure\Controller;

use App\Service\Util\Token;
use Infrastructure\Data\Session;
use Infrastructure\Kernel\Configuration;
use Infrastructure\Kernel\ServiceContainer;
use Infrastructure\Response\Json;
use Infrastructure\Response\Response;
use Infrastructure\Response\TemplateEngine;

abstract class AbstractController
{
    /**
     * @param string $serviceName
     * @return mixed
     * @throws \Exception
     */
    protected function getService(string $serviceName)
    {
        return ServiceContainer::get()->get($serviceName);
    }

    protected function getConfiguration() : Configuration
    {
        return $this->getService('configuration');
    }

    protected function json(array $arguments = []) : Response
    {
        return new Json($arguments);
    }

    protected function render(string $template, array $arguments = []) : Response
    {
        return new TemplateEngine($template, $arguments);
    }

    protected function view(string $template, array $arguments = []) : string
    {
        $templateEngine = new TemplateEngine($template, $arguments, false);
        return $templateEngine->content($arguments);
    }

    protected function getSession() : Session
    {
        return $this->getService('session');
    }

    protected function createToken(array $payload) : string
    {
        return Token::encode($payload, $this->getConfiguration()->get('SECRET'));
    }

    protected function getToken(string $token) : array
    {
        return Token::decode($token, $this->getConfiguration()->get('SECRET'));
    }
}
