<?php

namespace App\Abstracts;

use Exception;

abstract class CustomException extends Exception
{
    protected int $statusCode;

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }
}