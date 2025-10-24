<?php

namespace App\Exceptions;

use Exception;

class PaymentImportException extends Exception
{
    public function __construct(string $message, public readonly int $status = 422, public readonly ?array $context = null)
    {
        parent::__construct($message);
    }
}
