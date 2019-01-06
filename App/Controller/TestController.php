<?php

declare(strict_types=1);

use Infrastructure\Controller\AbstractController as Controller;
use Infrastructure\Response\Response;

class TestController extends Controller
{
    public function testAction() : Response
    {
        return $this->json(['hello' => 'hello world']);
    }
}
