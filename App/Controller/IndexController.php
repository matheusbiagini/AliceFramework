<?php

declare(strict_types=1);

namespace App\Controller;

use Infrastructure\Controller\AbstractController as Controller;
use Infrastructure\Request\Request;
use Infrastructure\Response\Response;

class IndexController extends Controller
{
    /** @var string[]  */
    protected $freeActions = [
        'indexAction',
    ];

    public function indexAction(Request $request) : Response
    {
        $this->redirect('login');
    }
}
