<?php

declare(strict_types=1);

namespace Infrastructure\Data;

use Firebase\JWT\JWT;
use Firebase\JWT\SignatureInvalidException;

abstract class Token
{
    public static function encode(array $payload, string $secret) : string
    {
        return JWT::encode($payload, $secret);
    }

    public static function decode(string $jwt, string $secret) : array
    {
        try {
            $payload = (array) JWT::decode($jwt, $secret, array('HS256'));
        } catch (SignatureInvalidException | \UnexpectedValueException $exception) {
            $payload = [];
        }

        return $payload;
    }
}
