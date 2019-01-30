<?php

declare(strict_types=1);

namespace Test\unit\Infrastructure\Data;

use Codeception\Test\Unit;
use Infrastructure\Data\Document;

class DocumentTest extends Unit
{
    public function testCpfMustBeValidAndInvalid() : void
    {
        $this->assertTrue(Document::isCpf('319.659.148-45'));
        $this->assertTrue(Document::isCpf('31965914845'));

        $this->assertFalse(Document::isCpf('125.352.052-10'));
        $this->assertFalse(Document::isCpf('00000000000'));
    }

    public function testCnpjMustBeValidAndInvalid() : void
    {
        $this->assertTrue(Document::isCnpj('26.574.988/0001-96'));
        $this->assertTrue(Document::isCnpj('47727744000176'));

        $this->assertFalse(Document::isCnpj('10.250.988/0001-96'));
        $this->assertFalse(Document::isCnpj('11111111111111'));
    }

    public function testEmailMustBeValidAndInvalid() : void
    {
        $this->assertTrue(Document::isEmail('matheus.biagini@gmail.com'));
        $this->assertFalse(Document::isEmail('goiaba.fruta'));
    }

    public function testShouldBeIsNullOrWhiteSpace() : void
    {
        $this->assertTrue(Document::isNullOrWhiteSpace(null));
        $this->assertTrue(Document::isNullOrWhiteSpace(''));
    }

    /**
     * @dataProvider dataProviderConvertForInteger
     * @param string $key
     * @param string $expected
     */
    public function testShouldConvertToInteger(string $key, string $expected) : void
    {
        $this->assertTrue(is_numeric(Document::integer($key)));
        $this->assertEquals($expected, Document::integer($key));
    }

    public function dataProviderConvertForInteger() : array
    {
        return [
            ['abobalhado987123', '987123'],
            ['123zica654Legal789', '123654789'],
            ['A1B2C3D4', '1234'],
            ['123456123', '123456123'],
        ];
    }
}
