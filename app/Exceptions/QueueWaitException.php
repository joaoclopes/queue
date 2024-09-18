<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\RedirectResponse;

class QueueWaitException extends Exception
{
    public function __construct($message = "O sistema está cheio, você entrou na fila e terá que aguardar.")
    {
        parent::__construct($message);
    }

    public function render($request): RedirectResponse
    {
        $userId = $request->input('user_id');
        $batchId = $request->input('batch_id');
        return redirect()->route('queue')->with(compact('userId', 'batchId'));
    }
}
