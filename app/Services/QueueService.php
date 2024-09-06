<?php

namespace App\Services;

use App\Repositories\QueueRepository;
use Illuminate\Support\Facades\Redis;

class QueueService
{
    public function __construct(private QueueRepository $queueRepository)
    {
    }

    public function create($data)
    {
        $queueQuantity = Redis::get();
        return $this->queueRepository->create($data);
    }
}