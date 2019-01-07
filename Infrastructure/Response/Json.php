<?php

declare(strict_types=1);

namespace Infrastructure\Response;

class Json implements Response
{
    /** @var mixed[] */
    private $arguments;

    public function __construct(array $arguments = [])
    {
        $this->arguments = $arguments;
        $this->render($this->arguments);
    }

    public function render(array $arguments = []) : void
    {
        echo json_encode($arguments);
    }
}
