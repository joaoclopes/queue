<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;

class QueueWaitException extends Exception
{
    public function __construct($message = "O sistema está cheio, você entrou na fila e terá que aguardar.")
    {
        parent::__construct($message);
    }

    public function render($request): JsonResponse
    {
        return response()->json([
            'success' => false,
            'queue' => true,
            'message' => 'O evento esta com fila, aguarde para ver se consegue um ingresso!'
        ], 409);
    }
}
