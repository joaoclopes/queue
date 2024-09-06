<?php

namespace App\Http\Controllers;

use App\Abstracts\CustomException;
use App\Services\QueueService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class QueueController
{
    public function __construct(private QueueService $queueService)
    {
    }

    public function queue(Request $request)
    {
        try {
            $queue = $this->queueService->create($request->all());

            if ($queue) {
                return response()->json([
                    'success' => true,
                    'data' => $queue,
                ], 200);
            }

            return response()->json([
                'success' => false,
                'data' => $queue,
            ], 400);
        } catch (CustomException $e) {
            Log::error('[QueueController::queue] Erro ao inserir cliente na fila: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'data' => $e->getMessage(),
            ], $e->getStatusCode());
        } catch (Exception $e) {
            Log::error('[QueueController::queue] Erro ao inserir cliente na fila: ' . $e->getMessage());
            Log::error($e);

            return response()->json([
                'success' => false,
                'data' => 'Failed to queue payment!',
            ], 400);
        }
    }
}