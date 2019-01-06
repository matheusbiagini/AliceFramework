<?php

declare(strict_types=1);

require_once '../vendor/autoload.php';

use Infrastructure\Kernel\Application;
use Infrastructure\Kernel\DependencyInjection;

$application = new Application(new DependencyInjection());
$application->main(MODE);
