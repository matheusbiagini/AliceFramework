<?php

declare(strict_types=1);

namespace Infrastructure\View\Twig\Helper;

use App\Service\Util\Cryptographer;
use App\Service\Util\Token;
use Infrastructure\Kernel\Configuration;
use Infrastructure\Kernel\ServiceContainer;

class Helper
{
    public function url(string $routeName, array $params = []) : string
    {
        return url($routeName, $params);
    }

    public function hash(string $text) : string
    {
        return Cryptographer::hash($text);
    }

    public function id(int $id) : string
    {
        return $this->encode(['id' => $id]);
    }

    public function getId(string $token) : ?int
    {
        $payload = $this->decode($token);

        return $payload['id'] ?? null;
    }

    public function encode(array $payload) : string
    {
        return Token::encode($payload, $this->getConfiguration()->get('SECRET'));
    }

    public function decode(string $token) : array
    {
        return Token::decode($token, $this->getConfiguration()->get('SECRET'));
    }

    /**
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public function config(string $key, $default = null)
    {
        return $this->getConfiguration()->get($key, $default);
    }

    private function getConfiguration() : Configuration
    {
        return ServiceContainer::get()->get('configuration');
    }
}
