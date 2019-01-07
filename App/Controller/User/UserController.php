<?php

declare(strict_types=1);

namespace App\Controller\User;

use App\Enum\Profile;
use App\Enum\Status;
use App\Service\User\UserService;
use Infrastructure\Controller\AbstractController as Controller;
use Infrastructure\Request\Request;
use Infrastructure\Response\Response;

class UserController extends Controller
{
    public function createAction(Request $request) : Response
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

    public function getAllAction(Request $request) : Response
    {
        $users = $this->getUserService()->getAll();

        return $this->json(['users' => $users]);
    }

    public function getByIdAction(Request $request) : Response
    {
        $id   = $request->getParam('id', null);

        $user = $this->getUserService()->getById((int) $id);

        return $this->json(['user' => $user]);
    }

    private function getUserService() : UserService
    {
        return $this->getService('user.service');
    }
}
