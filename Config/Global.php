<?php

declare(strict_types=1);

defined('PATH_ROOT') || define('PATH_ROOT', str_replace(['/web', '\web'], ['', ''], getcwd()));
defined('HOST') || define('HOST', $_SERVER['HTTP_HOST']);

function getHost() : string
{
    if (!empty($_SERVER['HTTP_X_FORWARDED_HOST'])) {
        $elements = explode(',', $_SERVER['HTTP_X_FORWARDED_HOST']);
        return trim(end($elements));
    }
    foreach (['HTTP_HOST', 'SERVER_NAME', 'SERVER_ADDR'] as $key) {
        if (!empty($_SERVER[$key])) {
            return trim($_SERVER[$key]);
        }
    }
    return '';
}

function getHostComplete() : string
{
    if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on' ) {
        return 'https://'. getHost();
    }

    return 'http://'. getHost();
}

function url(string $routeName, array $params = [])
{
    return \Infrastructure\Kernel\Route::url($routeName, $params);
}

function urlAll()
{
    return \Infrastructure\Kernel\Route::getUrlAll();
}

function translate(string $key, array $params = [])
{
    return \Infrastructure\Translation\Translate::getInstance()->translate($key, $params);
}

function translateAll()
{
    return \Infrastructure\Translation\Translate::getInstance()->getTranslateAll();
}

function helper()
{
    return new \Infrastructure\View\Twig\Helper\Helper();
}

function dd(... $expressions)
{
    $backtrace = debug_backtrace();
    $line      = $backtrace[0]['line'];
    $file      = $backtrace[0]['file'];
    echo "\nExport called at: $file ($line) \n";
    $count   = func_num_args();
    $argList = func_get_args();
    for ($i = 0; $i < $count; $i++) {
        echo "[$i]\n";
        var_export($argList[$i]);
        echo "\n";
    }
    die;
}