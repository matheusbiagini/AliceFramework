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

    public function main(Configuration $configuration, bool $buildRouting = true, $ignoreSessionStart = false) : void
    {
        ServiceContainer::set($this->dependencyInjection->getContainer());
        ServiceContainer::setConfiguration($configuration);

        #Charset UTF-8 AND America/Sao_Paulo
        header('Content-Type: text/html; charset=UTF-8', true);
        if (!$ignoreSessionStart) {
            session_start();
        }
        setlocale(LC_ALL, null);
        setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
        setlocale(LC_MONETARY,"pt_BR", "ptb");
        date_default_timezone_set('America/Sao_Paulo');
        #Timeout
        set_time_limit(300);
        #Error handle
        error_reporting(E_ALL);
        $debug = '0';

        if($this->getConfiguration()->get('MODE', 'dev') === 'dev') {
            $debug = '1';
        }

        ini_set('log_errors', $debug);
        ini_set('display_errors', $debug);
        ini_set('display_startup_erros', $debug);

        include str_replace(['/web'], [''], getcwd()) . '/Config/Global.php';

        if ($buildRouting) {
            $this->buildRouting();
        }
    }

    private function buildRouting() : void
    {
        $route = new Route();
        $route->make(new Slim());
    }

    private function getConfiguration() : Configuration
    {
        return ServiceContainer::getConfiguration();
    }
}
