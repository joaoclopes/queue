<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;

class QueueWaitException extends Exception
{
    // Construtor opcional para uma mensagem personalizada
    public function __construct($message = "O sistema está cheio, você entrou na fila e terá que aguardar.")
    {
        parent::__construct($message);
    }

    // Método para renderizar a exceção como uma resposta HTTP
    public function render($request): JsonResponse
    {
        return response()->json([
            'error' => 'Queue Wait',
            'message' => $this->getMessage(),
        ], 202); // Código HTTP 202: Accepted (indicando que o pedido foi aceito, mas ainda não processado)
    }
}
