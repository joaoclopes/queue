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
