<?php

declare(strict_types=1);

namespace App\Controller\Dashboard;

use Infrastructure\Controller\AbstractController as Controller;
use Infrastructure\Response\Response;

class DashboardController extends Controller
{
    public function indexAction() : Response
    {
        return $this->render('Dashboard/index.html.twig');
    }
}
