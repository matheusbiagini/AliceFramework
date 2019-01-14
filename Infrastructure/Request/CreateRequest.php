<?php

declare(strict_types=1);

namespace Infrastructure\Request;

class CreateRequest implements Request
{
    public function getParam(string $key, $default = null)
    {
        if (!isset($this->getParams()[$key])) {
            return $default;
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
}
