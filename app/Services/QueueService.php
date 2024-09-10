<?php

namespace App\Services;

use App\Repositories\QueueRepository;
use Illuminate\Support\Facades\Redis;

class QueueService
{
    public function __construct(private QueueRepository $queueRepository)
    {
    }

    public function getQueuePosition($queueId, $userId)
    {
        $queue = json_decode(Redis::get($queueId));
        return array_search($userId, $queue) + 1;
    }

    public function updateQueuePosition($queueKey, $userId)
    {
        $queue = $this->getQueue($queueKey);
        return $this->setQueue($queueKey, array_diff($queue, [$userId]));
    }

    public function insertUserInQueue($queueId, $userId)
    {
        $redisQueueKey = 'event:' . $queueId;
        $queue = $this->getQueue($redisQueueKey);
        if (!$queue) {
            return $this->setQueue($redisQueueKey, [$userId]);
        }

        array_push($queue, $userId);
        return $this->setQueue($redisQueueKey, $queue);
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