<?php

namespace App\Exceptions;

use Exception;

class Gw2ApiException extends Exception
{
    protected ?int $statusCode = null;

    public function __construct(string $message = "", int $statusCode = 0)
    {
        parent::__construct($message);
        $this->statusCode = $statusCode;
    }

    public function getStatusCode(): ?int
    {
        return $this->statusCode;
    }
}