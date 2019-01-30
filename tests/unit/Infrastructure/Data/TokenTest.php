<?php

declare(strict_types=1);

namespace Test\unit\Infrastructure\Data;

use Codeception\Test\Unit;
use Infrastructure\Data\Token;

class TokenTest extends Unit
{
    /**
     * @dataProvider dataProviderEncodeAndDecode
     * @param mixed[]  $payload
     * @param string $secret
     */
    public function testMustEncodeAndDecodeToken(array $payload, string $secret) : void
    {
        $token  = Token::encode($payload, $secret);

        $this->assertIsString($token);

        $decode = Token::decode($token, $secret);

        $this->assertEquals($payload, $decode);
    }

    public function dataProviderEncodeAndDecode() : array
    {
        return [
            [['name' => 'matheus'], '123456'],
            [['id' => 20], 'ak919ks92'],
            [['number' => 89.78], 'n9m92m0s'],
            [['date' => date('Y-m-d')], '546879132da312das21'],
        ];
    }
}
