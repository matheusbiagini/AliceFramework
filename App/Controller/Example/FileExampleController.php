<?php

declare(strict_types=1);

namespace App\Controller\Example;

use Infrastructure\Controller\AbstractController as Controller;
use Infrastructure\Response\Response;

class FileExampleController extends Controller
{
    protected $freeActions = [
        'exampleUploadAction',
    ];

    public function exampleUploadAction() : Response
    {
        $this->getSession()->set('auth', true);
        return $this->render('Example/File/upload.html.twig');
    }
}
