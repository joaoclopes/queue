<?php

namespace App\Http\Middleware;

use App\Services\EventService;
use Closure;
use Illuminate\Support\Facades\Redis;
use Illuminate\Http\Request;

class CheckUserLimit
{

    public function __construct(private EventService $eventService)
    {
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $ticketIsAvailable = $this->eventService->checkIfTicketIsAvailable($request->input('event_id'));
        if (!$ticketIsAvailable) {
            return response()->json(['message' => 'Infelizmente os ingressos para o evento estao esgotados.'], 429);
        }

        $userCanBuy = $this->eventService->checkIfUserCanBuy($request->all());
        if (!$userCanBuy) {
            // fazer o usuario entra na fila
            return response()->json(['message' => 'Voce foi inserido na fila, aguarde para ver se algum ticket volta para a compra.'], 201);
        }

        // Verifica o número atual de usuários ativos
        $currentCount = Redis::get($userCanBuy);
        $currentCount = $currentCount ? (int) $currentCount : 0;

        // Incrementa o número de usuários ativos
        Redis::incr(1);

        // Decrementa o número de usuários ativos quando a resposta for enviada
        Redis::decr(1);

        return $next($request);
    }
}
