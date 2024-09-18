<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\RedirectResponse;

class TicketSoldOutException extends Exception
{
    public function __construct($message = "O ingresso que você está tentando comprar está esgotado.")
    {
        parent::__construct($message);
    }

    public function render($request): RedirectResponse
    {
        return redirect()->route('home')->with('error', $this->getMessage());
    }
}
