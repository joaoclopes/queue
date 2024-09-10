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
            $queuePosition = $this->queueService->getQueuePosition('event:9cfa6d66-9dc7-41dc-929d-86d18da78d14', '9cfa6cb5-0af7-4f91-99e5-a22f416e65b5');
            // Loop que verifica a posicao na fila e envia pro front a posicao na fila a cada X segundos
            while ($queuePosition > 0) {
                $redisQueuePosition = $this->queueService->getQueuePosition('event:9cfa6d66-9dc7-41dc-929d-86d18da78d14', '9cfa6cb5-0af7-4f91-99e5-a22f416e65b5');
                $message = 'Posicao na fila: ' . $redisQueuePosition;
                // Regra para ver se e o proximo a ser atendido
                if ($redisQueuePosition == 1) {
                    $userCanBuy = $this->queueService->checkIfUserCanBuy('event:9cfa6d66-9dc7-41dc-929d-86d18da78d14', '9cfa6cb5-0af7-4f91-99e5-a22f416e65b5');
                    if ($userCanBuy) {
                        $message = 'Parabens, voce sera redirecionado para comprar seu ingresso';
                    };
                }
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
                if (isset($userCanBuy)) break;

                // Espera 1 segundo antes de enviar a próxima mensagem
                sleep(5);
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