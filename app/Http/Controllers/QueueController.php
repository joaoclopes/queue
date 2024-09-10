<?php

namespace App\Http\Controllers;

use App\Abstracts\CustomException;
use App\Services\QueueService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;

class QueueController
{
    public function __construct(private QueueService $queueService)
    {
    }

    public function getInQueue(Request $request)
    {
        try {
            $this->queueService->insertUserInQueue($request->input('event_id'), $request->input('user_id'));

            return response()->json([
                'success' => true,
                'message' => 'O usuario foi inserido na fila de espera com sucesso!',
            ], 200);
        } catch(CustomException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Ocorreu um erro ao inserir usuario na fila, tente novamente mais tarde! Error: ' . $e->getMessage()
            ], 500);
        }
    }

    public function queueStatus(Request $request)
    {
        $queueId = $request->input('event_id');
        $userId = $request->input('user_id');
        return response()->stream(function () use ($queueId, $userId) {
            $queuePosition = $this->queueService->getQueuePosition('event:034ada7d-d05b-45a2-8d75-20b812301b11', 'd218e4e5-6a1f-4a2a-b15e-4e6371149898');
            // Loop que verifica a posicao na fila e envia pro front a posicao na fila a cada X segundos
            while ($queuePosition > 0) {
                $redisQueuePosition = $this->queueService->getQueuePosition('event:034ada7d-d05b-45a2-8d75-20b812301b11', 'd218e4e5-6a1f-4a2a-b15e-4e6371149898');
                $message = $redisQueuePosition == 0 ?
                    'Parabens, voce sera redirecionado para comprar seu ingresso' :
                    'Posicao na fila: ' . $redisQueuePosition;
                // Envia uma mensagem para o cliente
                echo "data: " . json_encode(
                        [
                            'message' => $message,
                            'position' => $redisQueuePosition
                        ]
                    ) . "\n\n";
                
                // Limpa o buffer de saída e envia o conteúdo
                ob_flush();
                flush();

                // Espera 1 segundo antes de enviar a próxima mensagem
                sleep(5);
                // Regra para ver se e o proximo a ser atendido
                if ($redisQueuePosition == 1) {
                    $this->queueService->updateQueuePosition('event:034ada7d-d05b-45a2-8d75-20b812301b11', 'decaa1dc-9c8c-4d4f-b82d-873fc00500cc');
                    break;
                }
            }
        }, 200, [
            'Content-Type' => 'text/event-stream',
            'Cache-Control' => 'no-cache',
            'Connection' => 'keep-alive',
        ]);
    }

    // Seta a key do evento, para controlar/identificar a quantidade em fila
    // $queueKey = 'event:034ada7d-d05b-45a2-8d75-20b812301b11';
    // Seta o redis key baseado no evento e usuario
    // $redisKey = $queueKey . '_user:0fd420e7-3e17-4a7f-8d9a-52ca27145a8c';
    // $queuePosition = 5;
    // Salva no redis os dados de evento e usuario, com a devida posicao na fila
    // Redis::set($redisKey, $queuePosition);
}