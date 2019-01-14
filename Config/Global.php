<?php

declare(strict_types=1);

function url(string $routeName, array $params = [])
{
    return \Infrastructure\Kernel\Route::url($routeName, $params);
}

function translate(string $key, array $params = [])
{
    return \Infrastructure\Translation\Translate::getInstance()->translate($key, $params);
}