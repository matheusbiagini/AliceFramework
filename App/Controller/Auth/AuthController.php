<?php

declare(strict_types=1);

namespace App\Controller\Auth;

use Infrastructure\Controller\AbstractController as Controller;
use Infrastructure\Request\Request;
use Infrastructure\Response\Response;

class AuthController extends Controller
{
    /** @var string[]  */
    protected $freeActions = [
        'loginAction',
        'logoffAction',
    ];

    public function loginAction(Request $request) : Response
    {
        if ($this->getSession()->hasAuthenticated()) {
            return $this->redirect('dashboard');
        }

        return $this->render('Login/login.html.twig');
    }

    public function logoffAction(Request $request) : Response
    {
        $this->getSession()
            ->destroy();

        $redirect = $request->getParam('redirect', null);

        return $this->redirect($redirect === null ? 'login' : $redirect);
    }
}
