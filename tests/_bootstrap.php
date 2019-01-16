<?php
// This is global bootstrap for autoloading

declare(strict_types=1);

require getcwd() . '/vendor/autoload.php';

use Infrastructure\Kernel\Application;
use Infrastructure\Kernel\DependencyInjection;
use Infrastructure\Kernel\Configuration;

$application = new Application(new DependencyInjection());
$application->main(new Configuration(true), false);