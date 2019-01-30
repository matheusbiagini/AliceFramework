<?php

declare(strict_types=1);

namespace Test\unit\Infrastructure\Data;

use Codeception\Test\Unit;
use Infrastructure\Data\Slug;

class SlugTest extends Unit
{
    public function testShouldHaveSlug() : void
    {
        $slug = Slug::slugify('matheus biagini de lima dias');
        $this->assertEquals('matheus-biagini-de-lima-dias', $slug);
    }
}
