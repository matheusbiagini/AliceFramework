<?php

declare(strict_types=1);

namespace Infrastructure\Email\Exception;

class ErrorSendingEmail extends \RuntimeException implements \Throwable
{
    public function __construct(string $message)
    {
        parent::__construct($message);
    }
}
