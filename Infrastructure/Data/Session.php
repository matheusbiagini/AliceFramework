<?php

declare(strict_types=1);

namespace Infrastructure\Data;

class Session
{
    private const APP_KEY = '_app_';

    public function setAuthenticated() : self
    {
        return $this->set('auth', true);
    }

    public function setWebsiteAuthenticated() : self
    {
        return $this->set('authWebsite', true);
    }

    public function setWebsiteMultiFactorAuthenticated() : self
    {
        return $this->set('authWebsiteDisplayMultiFactor', true);
    }

    public function setDisabledWebsiteMultiFactorAuthenticated() : self
    {
        return $this->set('authWebsiteDisplayMultiFactor', false);
    }

    public function hasAuthenticated() : bool
    {
        return (bool) $this->get('auth', false);
    }

    public function hasWebsiteAuthenticated() : bool
    {
        return (bool) $this->get('authWebsite', false);
    }

    public function hasWebsiteMultiFactorAuthenticated() : bool
    {
        return (bool) $this->get('authWebsiteDisplayMultiFactor', false);
    }

    public function get(string $key, $default = null)
    {
        if (!isset($_SESSION[self::APP_KEY][$key])) {
            return $default;
        }

        return $_SESSION[self::APP_KEY][$key];
    }

    public function set(string $key, $value) : self
    {
        $_SESSION[self::APP_KEY][$key] = $value;
        return $this;
    }

    public function getAll() : array
    {
        return $_SESSION[self::APP_KEY];
    }

    public function destroy(bool $sessionDestroy = true) : void
    {
        $_SESSION[self::APP_KEY] = [];
        if ($sessionDestroy) {
            session_destroy();
        }
    }

    public static function session() : self
    {
        return new self();
    }
}
