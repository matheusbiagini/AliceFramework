<?php

declare(strict_types=1);

namespace App\Controller\Auth;

use App\Service\User\UserService;
use Infrastructure\Controller\AbstractController as Controller;
use Infrastructure\Request\Request;
use Infrastructure\Response\Response;

class AuthController extends Controller
{
    /** @var string[]  */
    protected $freeActions = [
        'loginAction',
        'logoffAction',
        'authAction',
        'forgotPasswordAction',
        'sendNewPasswordOfForgotPasswordAction',
    ];

    public function loginAction(Request $request) : Response
    {
        if ($this->getSession()->hasAuthenticated()) {
            return $this->redirect('adminDashboard');
        }

        return $this->render('Login/login.html.twig');
    }

    public function authAction(Request $request) : Response
    {
        $email = $request->getParam('email');

        $password = $request->getParam('password');

        $auth = $this->getUserService()->authenticate($email, $password);

        return $this->json(['success' => $auth]);
    }

    public function forgotPasswordAction(Request $request) : Response
    {
        return $this->render('Login/forgot.password.html.twig');
    }

    public function sendNewPasswordOfForgotPasswordAction(Request $request) : Response
    {
        $email = $request->getParam('email');

        $send = $this->getUserService()->forgotPassword($email);

        return $this->json(['success' => $send]);
    }

    public function logoffAction(Request $request) : Response
    {
        $this->getSession()
            ->destroy();

        $redirect = $request->getParam('redirect', null);

        return $this->redirect($redirect === null ? 'adminLogin' : $redirect);
    }

    private function getUserService() : UserService
    {
        return $this->getService('user.service');
    }
}
