<?php

declare(strict_types=1);

namespace App\Service\User;

use App\Entity\Domain\User;
use App\Entity\Domain\UserLogLogin;
use App\Enum\Profile;
use App\Repository\Domain\UserRepository;
use Infrastructure\Data\Cryptographer;
use Infrastructure\Data\Document;
use Infrastructure\Data\Errors;
use Infrastructure\Data\Session;
use Infrastructure\Email\Service\EmailService;
use Infrastructure\Email\Template\EmailTemplate;
use Infrastructure\Request\CreateRequest;
use Slim\Slim;

class UserService
{
    /** @var UserRepository $userRepository */
    private $userRepository;

    /** @var Session $session */
    private $session;

    /** @var EmailService $emailService */
    private $emailService;

    public function __construct(UserRepository $userRepository, Session $session, EmailService $emailService)
    {
        $this->userRepository = $userRepository;
        $this->session = $session;
        $this->emailService = $emailService;
    }

    public function save(?int $userId, ?int $profileId, ?string $name, ?string $email, ?string $password = null, ?int $status = null): array
    {
        $errors = [];

        $user = new User();

        if (empty(trim((string)$name))) {
            $errors[] = translate('EMPTY_NAME');
        }

        if (empty(trim($email)) || !Document::isEmail($email)) {
            $errors[] = translate('EMAIL_IS_INVALID');
        }

        if (empty($userId) && empty($password)) {
            if (empty($password)) {
                $errors[] = translate('EMPTY_NEW_PASSWORD');
            }

            if (!Cryptographer::isInThePasswordPolicy($password)) {
                $errors[] = translate('NOT_IN_PASSWORD_POLICY');
            }
        }

        if (count($errors) > 0) {
            return ['errors' => Errors::display($errors)];
        }

        if (!empty($userId)) {
            $user->set('id_user', $userId);
        }

        if ($profileId !== null) {
            $user->set('id_profile', $profileId);
        }

        if ($name !== null) {
            $user->set('name', $name);
        }

        if ($email !== null) {
            $user->set('email', $email);
        }

        if ($status !== null) {
            $user->set('status', $status);
        }

        if ($password !== null) {
            $user->set('password', Cryptographer::hash($password));
        }

        $userId = $user->flush();

        if (((int)$this->session->get('user')['id_user'] === $userId)) {
            $userCreated = $this->getById($userId);
            $userCreated['profile'] = (new Profile())->getDisplayName()[$userCreated['id_profile']];
            $this->session->setAuthenticated();
            $this->session->set('user', $userCreated);
        }

        return ['userId' => $userId];
    }

    public function changeStatus(int $userId, int $status) : bool
    {
        $user = new User();
        $user
            ->set('id_user', $userId)
            ->set('status', $status);

        $userId = $user->flush();

        return is_numeric($userId);
    }

    public function getAll(array $criteria = [], array $fields = ['*']): array
    {
        $users = $this->userRepository->findBy($criteria, $fields);

        if (!$users) {
            return [];
        }

        return $users;
    }

    public function listUsersActive(?string $filter, int $page, int $totalPerPage): array
    {
        $users = $this->userRepository->listUsersActive($filter, $page, $totalPerPage);

        if (count($users['users']) === 0) {
            return [];
        }

        $usersDisplay = [];

        foreach ($users['users'] as $user) {
            $user['profile'] = (new Profile())->getDisplayName()[$user['id_profile']];
            $usersDisplay[] = $user;
        }

        return ['users' => $usersDisplay, 'pagination' => $users['pagination']];
    }

    public function getById(int $userId, array $fields = ['*']): array
    {
        $user = $this->userRepository->findById($userId, $fields);

        if (!$user) {
            return [];
        }

        return $user;
    }

    public function authenticate(?string $email, ?string $password): bool
    {
        if (empty($email) || empty($password) || !Document::isEmail($email)) {
            return false;
        }

        $user = $this->userRepository->authenticateUser($email, Cryptographer::hash($password));

        if (count($user) > 0) {
            $user['profile'] = (new Profile())->getDisplayName()[$user['id_profile']];
            $this->session->setAuthenticated();
            $this->session->set('user', $user);
            $this->createLogLogin((int)$user['id_user']);
            return true;
        }

        return false;
    }

    public function forgotPassword(?string $email): bool
    {
        if (empty($email) || !Document::isEmail($email)) {
            return false;
        }

        $user = $this->userRepository->findByEmailAndStatusActive($email);

        if (count($user) > 0) {
            $newPassword = Cryptographer::generatePassword(10);
            $entity = new User();
            $entity
                ->set($entity->getPrimaryKey(), $user[$entity->getPrimaryKey()])
                ->set('password', Cryptographer::hash($newPassword))
                ->flush();

            $this->emailService
                ->addSubject(translate('FORGOT_PASSWORD'))
                ->addBody(EmailTemplate::forgotPassword($email, $user['name'], $newPassword))
                ->addTo($email);

            return $this->emailService->send();
        }

        return false;
    }

    private function createLogLogin(int $userId): void
    {
        $log = new UserLogLogin();
        $log
            ->set('id_user', $userId)
            ->set('dateLogin', date("Y-m-d H:i:s"))
            ->set('info', json_encode((new CreateRequest(new Slim()))->getServer()))
            ->set('id_user', $userId);

        $log->flush();
    }

    public function changePassword(int $userId, ?string $newPassword, ?string $oldPassword) : array
    {
        $errors = [];

        if (empty($newPassword)) {
            $errors[] = translate('EMPTY_NEW_PASSWORD');
        }

        if (empty($oldPassword)) {
            $errors[] = translate('EMPTY_OLD_PASSWORD');
        }

        if (!Cryptographer::isInThePasswordPolicy($newPassword)) {
            $errors[] = translate('NOT_IN_PASSWORD_POLICY');
        }

        $userEntity = $this->userRepository->findById($userId);

        if (count($userEntity) === 0) {
            $errors[] = translate('USER_NOT_FOUND');
        }

        if ($userEntity['password'] !== Cryptographer::hash($oldPassword)) {
            $errors[] = translate('OLD_PASSWORD_DOES_NOT_CHECK');
        }

        if (count($errors) > 0) {
            return ['errors' => Errors::display($errors)];
        }

        $user = new User();
        $user->set('id_user', $userId);
        $user->set('password', Cryptographer::hash($newPassword));
        $user->flush();

        return ['userId' => $userId];
    }
}
