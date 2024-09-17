<?php

namespace App\Http\Controllers;

use App\Abstracts\CustomException;
use App\Http\Requests\Batch\CheckBatchStatusRequest;
use App\Http\Requests\Batch\BuyBatchRequest;
use App\Http\Requests\Batch\StoreBatchRequest;
use App\Services\BatchService;

class BatchController
{
    public function __construct(private BatchService $batchService)
    {
    }

    public function store(StoreBatchRequest $request)
    {
        try {
            $data = $request->validated();
            if (!$data) {
                return response()->json([
                    'success' => false,
                    'message' => 'Ocorreu um erro criar o lote, preencha os dados corretamente!'
                ], 400);
            }
            $this->batchService->store($data);

            return response()->json([
                'success' => true,
                'message' => 'O lote foi criado com sucesso!',
            ], 200);
        } catch (CustomException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Ocorreu um erro criar o lote, tente novamente mais tarde! Error: ' . $e->getMessage()
            ], 500);
        }
    }

    public function buyBatch(BuyBatchRequest $request)
    {
        try {
            $data = $request->validated();
            if (!$data) {
                return response()->json([
                    'success' => false,
                    'message' => 'Algum dado invalido, preencha os dados corretamente!'
                ], 400);
            }
            $this->batchService->buyBatch($data);

            return response()->json([
                'success' => true,
                'message' => 'O lote foi comprado com sucesso!',
            ], 200);
        } catch (CustomException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Ocorreu um erro ao atrelar o usuario no lote, tente novamente mais tarde! Error: ' . $e->getMessage()
            ], 500);
        }
    }

    public function checkBatchStatus(CheckBatchStatusRequest $request)
    {
        try {
            $data = $request->validated();
            if (!$data) {
                return response()->json([
                    'success' => false,
                    'message' => 'Ocorreu um erro ao buscar o status do lote, preencha os dados corretamente!'
                ], 400);
            }
            $checkStatus = $this->batchService->checkBatchStatus($data);

            return response()->json([
                'success' => true,
                'status' => $checkStatus,
                'message' => $checkStatus ?
                    'Usuario pode comprar ingresso!' :
                    'No momento ainda nao e possivel realizar a compra, aguarde.',
            ], 200);
        } catch (CustomException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Ocorreu um erro ao recuperar o status do lote! Error: ' . $e->getMessage()
            ], 500);
        }
    }
}
