<?php

declare(strict_types=1);

namespace Infrastructure\Request;

use Infrastructure\Data\AntiInjection;
use Infrastructure\View\Twig\Helper\Helper;
use Slim\Slim;

class CreateRequest implements Request
{
    /** @var \Slim\Slim $slim */
    private $slim;

    public function __construct(Slim $slim)
    {
        $this->slim = $slim;
    }

    public function getSlim() : Slim
    {
        return $this->slim;
    }

    public function getParam(string $key, $default = null)
    {
        if (!isset($this->getParams()[$key])) {
            return $default;
        }

        //return $this->getParams()[$key];

        if (is_string($this->getParams()[$key])) {
            return AntiInjection::sanitize($this->getParams()[$key]);
        }

        return $this->getParams()[$key];
    }

    public function getServer() : array
    {
        return $_SERVER;
    }

    public function getBody() : string
    {
        return file_get_contents("php://input");
    }

    public function getStatusCode() : int
    {
        return http_response_code();
    }

    public function json() : string
    {
        return json_encode($this->getBody());
    }

    private function getParams() : array
    {
        return $_REQUEST;
    }

    public function isAjax() : bool
    {
        return isset($this->getServer()['HTTP_X_REQUESTED_WITH']) && $this->getServer()['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest';
    }

    public function getFiles() : array
    {
        return $_FILES;
    }

    public function getHelper(): Helper
    {
        return new Helper();
    }
}
