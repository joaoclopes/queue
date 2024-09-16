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
            'status' => 409,
            'redirect' => route('queue'),
            'message' => $this->getMessage(),
            'user_id' => $request->input('user_id'),
            'event_id' => $request->input('event_id')
        ], 409);
    }
}
