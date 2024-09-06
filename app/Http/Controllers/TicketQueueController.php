<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use App\Events\QueueUpdated;

class TicketQueueController extends Controller
{
    // Adiciona um usuário à fila
    public function joinQueue(Request $request)
    {
        $userId = $request->input('user_id');
        $ticketId = $request->input('ticket_id');

        // Adiciona o usuário na fila
        Redis::lpush("queue:{$ticketId}", $userId);

        // Notifica o frontend sobre a atualização da fila
        event(new QueueUpdated($ticketId));

        return response()->json(['message' => 'Usuário adicionado à fila.']);
    }

    // Retira o usuário da fila
    public function leaveQueue(Request $request)
    {
        $userId = $request->input('user_id');
        $ticketId = $request->input('ticket_id');

        // Remove o usuário da fila
        Redis::lrem("queue:{$ticketId}", 0, $userId);

        // Notifica o frontend sobre a atualização da fila
        event(new QueueUpdated($ticketId));

        return response()->json(['message' => 'Usuário removido da fila.']);
    }

    // Libera o próximo usuário na fila para compra
    public function processQueue(Request $request)
    {
        $ticketId = $request->input('ticket_id');

        // Remove o próximo usuário da fila
        $userId = Redis::rpop("queue:{$ticketId}");

        if ($userId) {
            // Notifica o próximo usuário sobre a disponibilidade do ingresso
            // Você pode adicionar lógica aqui para notificar o usuário via email ou outra forma
            event(new QueueUpdated($ticketId));
        }

        return response()->json(['message' => 'Processando a fila.']);
    }
}
