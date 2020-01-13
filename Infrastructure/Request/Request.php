<?php

declare(strict_types=1);

namespace Infrastructure\Request;

use Infrastructure\View\Twig\Helper\Helper;
use Slim\Slim;

interface Request
{
    public function getServer() : array;
    public function getParam(string $key, $default = null);
    public function getBody() : string;
    public function getStatusCode() : int;
    public function json() : string;
    public function isAjax() : bool;
    public function getFiles() : array;
    public function getSlim() : Slim;
    public function getHelper() : Helper;
}
