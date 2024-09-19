<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;

class TicketSoldOutException extends Exception
{
    public function __construct($message = "O ingresso que você está tentando comprar está esgotado.")
    {
        parent::__construct($message);
    }

    public function render($request): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => 'Infelizmente os ingressos esgotaram!'
        ], 400);
    }
}
