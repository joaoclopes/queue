<?php

namespace App\Repositories;

use App\Models\Batch;
use Illuminate\Support\Facades\Redis;

class BatchRepository
{
    public function __construct(private UserRepository $userRepository)
    {
    }

    public function store($data)
    {
        return Batch::create($data);
    }

    public function buyBatch($data)
    {
        $batch = Batch::find($data['batch_id']);

        return $batch->users()->attach($data['user_id']);
    }

    public function getById($batchId)
    {
        return Batch::find($batchId);
    }

    public function updateSlotsAvailable($batchId)
    {
        $batch = $this->getById($batchId);
        $batch->slots_available -= 1;
        $batch->save();
        return $batch;
    }

    public function getAmountOfUsersTryingToBuy($batchId)
    {
        return Redis::get('lock_batch:' . $batchId);
    }

    public function insertUserInLock($batchId)
    {
        $redisKey = 'lock_batch:' . $batchId;
        Redis::incr($redisKey);
    }
}