<?php

namespace App\Services;

use App\Repositories\QueueRepository;
use Illuminate\Support\Facades\Redis;

class QueueService
{
    public function __construct(private QueueRepository $queueRepository)
    {
    }

    public function setQueuePosition($queueKey, $userId)
    {
        $queue = $this->getQueue($queueKey);
        if (!$queue) {
            return $this->setQueue($queueKey, [$userId]);
        }

        array_push($queue, $userId);
        return $this->setQueue($queueKey, $queue);
    }

    public function getQueuePosition($redisKey, $userId)
    {
        $queue = json_decode(Redis::get($redisKey));
        return array_search($userId, $queue) + 1;
    }

    public function updateQueuePosition($queueKey, $userId)
    {
        $queue = $this->getQueue($queueKey);
        return $this->setQueue($queueKey, array_diff($queue, [$userId]));
    }

    private function getQueue($queueKey)
    {
        return json_decode(Redis::get($queueKey));
    }

    private function setQueue($queueKey, $data)
    {
        return Redis::set($queueKey, json_encode($data));
    }
}