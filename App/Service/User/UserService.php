<?php

declare(strict_types=1);

namespace App\Service\User;

use App\Entity\Domain\User;
use App\Entity\Domain\UserLogLogin;
use App\Enum\Profile;
use App\Repository\Domain\UserRepository;
use Infrastructure\Data\Cryptographer;
use Infrastructure\Data\Document;
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
        $this->session        = $session;
        $this->emailService   = $emailService;
    }

    public function save(?int $userId = null, int $profileId, string $name, string $email, string $password, int $status) : int
    {
        $user = new User();

        if (!empty($userId)) {
            $user->set('id_user', $userId);
        }

        $user
            ->set('id_profile', $profileId)
            ->set('name', $name)
            ->set('email', $email)
            ->set('password', Cryptographer::hash($password))
            ->set('status', $status);

        return $user->flush();
    }

    public function getAll(array $criteria = [], array $fields = ['*']) : array
    {
        $users = $this->userRepository->findBy($criteria, $fields);

        if (!$users) {
            return [];
        }

        return $users;
    }

    public function getById(int $userId, array $fields = ['*']) : array
    {
        $user = $this->userRepository->findById($userId, $fields);

        if (!$user) {
            return [];
        }

        return $user;
    }

    public function authenticate(?string $email, ?string $password) : bool
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

    public function forgotPassword(?string $email) : bool
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

    private function createLogLogin(int $userId) : void
    {
        $log = new UserLogLogin();
        $log
            ->set('id_user', $userId)
            ->set('dateLogin',date("Y-m-d H:i:s"))
            ->set('info', json_encode((new CreateRequest(new Slim()))->getServer()))
            ->set('id_user', $userId);

        $log->flush();
    }
}
