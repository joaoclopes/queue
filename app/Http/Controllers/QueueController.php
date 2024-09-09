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
    
    public function test()
    {
        return response()->json([
            'success' => true,
            'data' => 'teste',
        ], 200);
    }

    public function enterInQueue(Request $request)
    {
        return response()->stream(function () {
            // Seta o redis key baseado no evento e usuario
            $redisKey = 'queue_event:034ada7d-d05b-45a2-8d75-20b812301b11_user:0fd420e7-3e17-4a7f-8d9a-52ca27145a8c';
            // Seta a posicao inicial da fila
            $queuePosition = 4;
            // Salva no redis os dados de evento e usuario, com a devida posicao na fila
            Redis::set($redisKey, $queuePosition);

            // Loop que verifica a posicao na fila e envia pro front a posicao na fila a cada X segundos
            while ($queuePosition > 0) {
                $redisQueuePosition = Redis::get($redisKey);
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
                // Regra para ver se a fila desceu
                $newQueuePosition = $redisQueuePosition - 1;
                Redis::set($redisKey, $newQueuePosition);

            }
        }, 200, [
            'Content-Type' => 'text/event-stream',
            'Cache-Control' => 'no-cache',
            'Connection' => 'keep-alive',
        ]);
    }
}