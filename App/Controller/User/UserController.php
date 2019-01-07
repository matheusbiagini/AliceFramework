<?php

declare(strict_types=1);

namespace App\Controller\User;

use App\Enum\Profile;
use App\Enum\Status;
use App\Service\User\UserService;
use Infrastructure\Controller\AbstractController as Controller;
use Infrastructure\Response\Response;

class UserController extends Controller
{
    public function createAction() : Response
    {
        $user = $this->getUserService()->create(
            Profile::ADMIN,
            'Matheus Biagini',
            'matheus.biagini@gmail.com',
            'batatinha',
            Status::ACTIVE
        );

        return $this->json(['user' => $user]);
    }

    private function getUserService() : UserService
    {
        return $this->getService('user.service');
    }
}
