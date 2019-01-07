<?php

declare(strict_types=1);

namespace Infrastructure\Response;

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
}
