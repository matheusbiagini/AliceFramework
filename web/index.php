<?php

declare(strict_types=1);

require_once '../vendor/autoload.php';

use Infrastructure\Kernel\Application;
use Infrastructure\Kernel\DependencyInjection;
use Infrastructure\Kernel\Configuration;

$application = new Application(new DependencyInjection());
$application->main(new Configuration(false));
