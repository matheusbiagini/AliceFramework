<?php

declare(strict_types=1);

namespace Infrastructure\Response;

use Infrastructure\Data\Session;
use Infrastructure\Translation\Translate;
use Infrastructure\View\Twig\Helper\Helper;

class TemplateEngine implements Response
{
    /** @var string */
    private const PATH = '../App/View/';

    /** @var \Twig_Environment */
    private $twig;

    /** @var string $template */
    private $template;

    public function __construct(string $template, array $arguments = [], bool $print = true)
    {
        $this->twig     = new \Twig_Environment(new \Twig_Loader_Filesystem([self::PATH]));
        $this->template = $template;

        $this->createHelpers();

        if (!$print) {
            return;
        }

        $this->render($arguments);
    }

    public function render(array $arguments = []): void
    {
        echo $this->content($arguments);
    }

    public function content(array $arguments = []) : string
    {
        return $this->twig->render($this->template, $arguments);
    }

    private function createHelpers() : void
    {
        $this->twig->addGlobal('helper', new Helper());
        $this->twig->addGlobal('session', Session::session());
        $this->twig->addGlobal('language', Translate::getInstance());
    }
}
