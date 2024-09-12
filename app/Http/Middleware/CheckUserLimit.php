<?php

namespace App\Http\Middleware;

use Closure;
use App\Services\EventService;
use Illuminate\Support\Facades\Redis;

class CheckUserLimit
{
    protected $eventService;

    public function __construct(EventService $eventService)
    {
        $this->eventService = $eventService;
    }

    public function handle($request, Closure $next)
    {
        $eventId = $request->input('event_id');
        $ticketIsAvailable = $this->eventService->checkIfTicketIsAvailable($eventId);
        if (!$ticketIsAvailable) {
            // ingressos esgostados, montar alguma comunicacao com o gerenciador de fila pra rancar a fila e notificar os clientes que ainda estao na fila
            return response()->json(['message' => 'Infelizmente os ingressos para o evento estao esgotados.'], 429);
        }

        $userCanBuy = $this->eventService->checkIfHasQueue($eventId, $request->input('user_id'));
        if (!$userCanBuy) {
            // fazer o usuario entrar na fila
            return response()->json(['message' => 'Voce foi inserido na fila, aguarde para ver se algum ticket volta para a compra.'], 201);
        }

        return $next($request);
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
