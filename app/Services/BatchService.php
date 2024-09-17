<?php

namespace App\Services;

use App\Exceptions\QueueWaitException;
use App\Exceptions\TicketSoldOutException;
use App\Repositories\BatchRepository;

class BatchService
{
    public function __construct(protected BatchRepository $batchRepository)
    {
    }

    public function store($data)
    {
        return $this->batchRepository->store($data);
    }

    public function buyBatch($data)
    {
        $ticketIsAvailable = $this->checkIfBatchIsAvailableToBuy($data['batch_id']);
        if (!$ticketIsAvailable) {
            // ingressos esgotados
            throw new TicketSoldOutException();
        }

        $userCanBuy = $this->checkIfHasQueue($data['batch_id'], $data['user_id']);
        if (!$userCanBuy) {
            // fazer o usuario entrar na fila
            throw new QueueWaitException();
        }
        $this->batchRepository->updateSlotsAvailable($data['event_id']);
        return $this->batchRepository->buyBatch($data);
        return true;
    }

    public function checkIfBatchIsAvailableToBuy($batchId)
    {
        $batch = $this->batchRepository->getById($batchId);
        return ($batch->slots > $batch->users()->count());
    }

    public function checkIfHasQueue($batchId, $userId)
    {
        $batch = $this->batchRepository->getById($batchId);
        $redisLock = $this->batchRepository->getAmountOfUsersTryingToBuy($batchId);
        if (!$redisLock || $redisLock < $batch->slots_available) {
            $this->batchRepository->insertUserInLock($batchId, $userId);
            return true;
        }

        return false;
    }

    public function checkBatchStatus($data)
    {
        $batch = $this->batchRepository->getById($data['batch_id']);
        // Validar se ainda tem ticket disponivel para compra
        if (!$this->checkIfBatchIsAvailableToBuy($batch->id)) {
            throw new TicketSoldOutException();
        }

        $redisLock = $this->batchRepository->getAmountOfUsersTryingToBuy($batch->id);
        // verifica se tem menos usuarios no redisLock que vagas disponiveis
        if (!$redisLock || $redisLock < $batch->slots_available) {
            return true;
        }

        return false;
    }
}