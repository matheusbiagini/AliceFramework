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
    }

    private function json(array $arguments) : string
    {
        return json_encode($arguments);
    }

    public function __toString()
    {
        echo $this->json($this->arguments);
    }


}
