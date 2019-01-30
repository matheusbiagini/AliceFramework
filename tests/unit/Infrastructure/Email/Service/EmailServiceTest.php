<?php

declare(strict_types=1);

namespace Test\unit\Infrastructure\Email\Service;

use Codeception\Test\Unit;
use Infrastructure\Email\Exception\ErrorSendingEmail;
use Infrastructure\Email\Service\EmailService;
use Infrastructure\Kernel\ServiceContainer;

class EmailServiceTest extends Unit
{
    private function getInstance(bool $mock = false) : EmailService
    {
        $service = ServiceContainer::get()->get('email');

        if ($mock === true) {
            return $this->make($service, ['send' => function () { return true; }]);
        }

        return $service;
    }

    public function testShouldSuccessfullySendEmail() : void
    {
        $service = $this->getInstance(true);
        $service->addTo('matheus.biagini@gmail.com', 'Matheus Biagini');
        $service->addSubject('Test Unitário de e-mail do Alice Framework');
        $service->addBody('Hello World');
        $send = $service->send();

        $this->assertTrue($send);
    }

    public function testShouldThrowExceptionErrorSendingEmail() : void
    {
        /** @var EmailService $service */
        $service = $this->getInstance();

        $service->addTo('cocorico', 'Cocorico');
        $service->addSubject('Test Unitário de e-mail do Alice Framework');
        $service->addBody('Cocorico');

        $this->expectException(ErrorSendingEmail::class);

        $service->send();
    }
}
