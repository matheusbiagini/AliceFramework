<?php

declare(strict_types=1);

namespace Config\Translation;

use Infrastructure\Translation\Translation;

class English implements Translation
{
    public function getKey(): string
    {
        return 'en';
    }

    public function translations(): array
    {
        return [
            'name' => 'Name',
            'example_complex' => "My name is {name}",
        ];
    }
}
