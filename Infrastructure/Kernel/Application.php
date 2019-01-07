<?php

declare(strict_types=1);

namespace Infrastructure\Kernel;

use Slim\Slim;

class Application
{
    private $dependencyInjection;

    public function __construct(DependencyInjection $dependencyInjection)
    {
        $this->dependencyInjection = $dependencyInjection;
    }

    public function main() : void
    {
        ServiceContainer::set($this->dependencyInjection->getContainer());

        #Charset UTF-8 AND America/Sao_Paulo
        header('Content-Type: text/html; charset=UTF-8', true);
        setlocale(LC_ALL, null);
        setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
        setlocale(LC_MONETARY,"pt_BR", "ptb");
        date_default_timezone_set('America/Sao_Paulo');
        #Timeout
        set_time_limit(300);
        #Error handle
        define('ERR_LEVEL', E_ALL);
        error_reporting(ERR_LEVEL);
        $debug = '0';

        if($this->getConfiguration()->get('MODE', 'dev') === 'dev') {
            $debug = '1';
        }

        ini_set('log_errors', $debug);
        ini_set('display_errors', $debug);
        ini_set('display_startup_erros', $debug);


        $this->buildRouting();
    }

    private function buildRouting() : void
    {
        $route = new Route();
        $route->make(new Slim());
    }

    private function getConfiguration() : Configuration
    {
        return ServiceContainer::get()->get('configuration');
    }
}
