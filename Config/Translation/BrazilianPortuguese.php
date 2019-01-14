<?php

declare(strict_types=1);

namespace Config\Translation;

use Infrastructure\Translation\Translation;

class BrazilianPortuguese implements Translation
{
    public function getKey(): string
    {
        return 'pt-br';
    }

    public function translations(): array
    {
        return [
            'name' => 'Nome',
            'example_complex' => "Meu nome é {name}",
        ];
    }
}
