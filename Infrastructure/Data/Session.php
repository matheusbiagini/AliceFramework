<?php

declare(strict_types=1);

namespace Infrastructure\Data;

class Session
{
    /** @var mixed[] $session */
    private $session;

    public function __construct()
    {
        $session = $_SESSION['_app_'] = [];
        $this->session = $session;
    }

    public function hasAuthenticated() : bool
    {
        return (bool) $this->get('auth', false);
    }

    public function get(string $key, $default = null)
    {
        if (!isset($this->session[$key])) {
            return $default;
        }

        return $this->session[$key];
    }

    public function set(string $key, $value) : self
    {
        $this->session[$key] = $value;
        return $this;
    }

    public function getAll() : array
    {
        return $this->session;
    }

    public function destroy() : void
    {
        $this->session = [];
        session_destroy();
    }
}
