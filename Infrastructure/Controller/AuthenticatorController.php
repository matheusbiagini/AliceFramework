<?php

declare(strict_types=1);

namespace Infrastructure\Controller;

use Infrastructure\Data\Session;
use Infrastructure\Request\Request;

abstract class AuthenticatorController
{
    /** @var string $action */
    private $action;

    public function __construct(Request $request, string $action)
    {
        $this->action = $action;
        $this->checkAuthentication($this->freeActions ?? [], $request);
    }

    protected function getCurrentController() : string
    {
        return get_class($this);
    }

    protected function getCurrentAction() : string
    {
        return $this->action;
    }

    private function checkAuthentication(array $freeActions, Request $request) : void
    {
        /** @var Session $session */
        $session            = $this->getSession();
        $hasAuthenticated   = $session->hasAuthenticated();
        $urlLogoff          = url('logoff');

        if (in_array($this->getCurrentAction(), $freeActions)) {
            return;
        }

        if ($hasAuthenticated) {
            return;
        }

        if ($request->isAjax()) {
            echo "<script>window.location.href='{$urlLogoff}';</script>";
            return;
        }

        $request->getSlim()->response->redirect($urlLogoff);
        return;
    }
}
