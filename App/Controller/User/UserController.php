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
    public function createAction(Request $request): Response
    {
        return $this->render(
            'User/edit.user.html.twig',
            [
                'id' => '',
                'user' => [],
                'mode' => 'create',
                'profiles' => (new Profile())->getDisplayName(),
            ]
        );
    }

    public function editAction(Request $request): Response
    {
        $id = $request->getParam('user', null);

        if (empty($id)) {
            return $this->redirect('adminIndex');
        }

        $user = $this->getUserService()->getById((int)$request->getHelper()->getId($id));

        if (count($user) === 0) {
            return $this->redirect('adminIndex');
        }

        return $this->render(
            'User/edit.user.html.twig',
            [
                'id' => $id,
                'user' => $user,
                'mode' => 'edit',
                'profiles' => (new Profile())->getDisplayName(),
            ]
        );
    }

    public function changePasswordAction(Request $request): Response
    {
        $id = $request->getParam('user', null);

        if (empty($id)) {
            return $this->redirect('adminIndex');
        }

        $user = $this->getUserService()->getById((int)$request->getHelper()->getId($id));

        if (count($user) === 0) {
            return $this->redirect('adminIndex');
        }

        return $this->render(
            'User/change.password.user.html.twig',
            [
                'id' => $id,
                'user' => $user,
            ]
        );
    }

    public function saveAction(Request $request): Response
    {
        $id = $request->getParam('userId', null);
        $name = $request->getParam('userName', null);
        $email = $request->getParam('userEmail', null);
        $password = $request->getParam('userPassword', null);
        $profile = $request->getParam('userProfile', null);
        $status = $request->getParam('userStatus', Status::ACTIVE);

        $response = $this->getUserService()->save(
            empty($id) ? null : $request->getHelper()->getId($id),
            empty($profile) ? null : (int)$profile,
            $name,
            $email,
            $password,
            (int)$status
        );

        if (!isset($response['errors'])) {
            return $this->json(['success' => true]);
        }

        return $this->json(['success' => false, 'errors' => $response['errors']]);
    }

    public function saveChangePasswordAction(Request $request): Response
    {
        $id = $request->getParam('userId', null);

        if (empty($id)) {
            return $this->redirect('adminIndex');
        }

        $response = $this->getUserService()->changePassword(
            $request->getHelper()->getId($id),
            $request->getParam('userPassword', null),
            $request->getParam('userOldPassword', null)
        );

        if (!isset($response['errors'])) {
            return $this->json(['success' => true]);
        }

        return $this->json(['success' => false, 'errors' => $response['errors']]);
    }

    public function listAction(Request $request): Response
    {
        return $this->render('User/users.html.twig');
    }

    public function listUsersAction(Request $request): Response
    {
        $totalPerPage = 25;

        $users = $this->getUserService()->listUsersActive(
            $request->getParam('filter', ''),
            (int)$request->getParam('page', 1),
            $totalPerPage
        );

        return $this->render(
            'User/list.users.html.twig',
            [
                'users' => isset($users['users']) ? $users['users'] : [],
                'pagination' => isset($users['pagination']) ? $users['pagination'] : [],
            ]
        );
    }

    public function deleteAction(Request $request): Response
    {
        $id = $request->getParam('user', null);

        if (empty($id)) {
            return $this->json(['success' => false]);
        }

        $id = (int)$request->getHelper()->getId($id);

        $user = $this->getUserService()->changeStatus((int)$id, Status::EXCLUDED);

        return $this->json(['success' => $user]);
    }

    private function getUserService(): UserService
    {
        return $this->getService('user.service');
    }
}
