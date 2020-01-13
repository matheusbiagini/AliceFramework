<?php

declare(strict_types=1);

namespace App\Controller\Dashboard;

use App\Service\Client\CertificateService;
use App\Service\Client\ClientService;
use Infrastructure\Controller\AbstractController as Controller;
use Infrastructure\Response\Response;

class DashboardController extends Controller
{
    public function indexAction() : Response
    {
        return $this->render('Dashboard/index.html.twig', [
            'totalClients' => 0,
            'totalCertificate' => 0,
            'totalAccess' => 0,
        ]);
    }
}
