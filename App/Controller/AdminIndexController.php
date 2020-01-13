<?php

declare(strict_types=1);

namespace App\Controller;

use Infrastructure\Controller\AbstractController as Controller;
use Infrastructure\Data\Cookie;
use Infrastructure\Request\Request;
use Infrastructure\Response\Response;

class AdminIndexController extends Controller
{
    /** @var string[]  */
    protected $freeActions = [
        'adminIndexAction',
    ];

    public function adminIndexAction(Request $request) : Response
    {
        $language = $request->getParam('lang', $request->getHelper()->config('LANGUAGE'));

        Cookie::cookie()->set('language', $language);

        $this->redirect('adminLogin');
    }
}
