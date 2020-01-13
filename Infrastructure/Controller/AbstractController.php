<?php

declare(strict_types=1);

namespace Infrastructure\Controller;

use Infrastructure\Data\Token;
use Infrastructure\Data\Cookie;
use Infrastructure\Data\Session;
use Infrastructure\Kernel\Configuration;
use Infrastructure\Kernel\ServiceContainer;
use Infrastructure\Response\Json;
use Infrastructure\Response\Response;
use Infrastructure\Response\TemplateEngine;

abstract class AbstractController extends AuthenticatorController
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

    protected function getSession() : Session
    {
        return $this->getService('session');
    }

    protected function getCookie() : Cookie
    {
        return $this->getService('cookie');
    }

    protected function json(array $arguments = []) : Response
    {
        return new Json($arguments);
    }

    protected function render(string $template, array $arguments = []) : Response
    {
        return new TemplateEngine($template, $arguments);
    }

    protected function partial(string $template, array $arguments = []) : string
    {
        $templateEngine = new TemplateEngine($template, $arguments, false);
        return $templateEngine->content($arguments);
    }

    protected function redirect(string $routeName, array $params = []) : Response
    {
        header('Location: ' . url($routeName, $params));
        return $this->json();
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
