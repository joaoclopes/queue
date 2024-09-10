<?php

namespace App\Services;

use App\Repositories\EventRepository;
use App\Repositories\QueueRepository;
use Illuminate\Support\Facades\Redis;

class QueueService
{
    public function __construct(private QueueRepository $queueRepository, private EventRepository $eventRepository)
    {
    }

    private function getQueue($queueKey)
    {
        return json_decode(Redis::get($queueKey));
    }

    private function setQueue($queueKey, $data)
    {
        return Redis::set($queueKey, json_encode($data));
    }

    public function getQueuePosition($queueId, $userId)
    {
        $queue = json_decode(Redis::get($queueId));
        return array_search($userId, $queue) + 1;
    }

    public function updateQueuePosition($queueKey, $userId)
    {
        $queue = $this->getQueue($queueKey);
        return $this->setQueue($queueKey, array_values(array_diff($queue, [$userId])));
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

    public function checkIfUserCanBuy($eventId, $userId)
    {
        $event = $this->eventRepository->getById($eventId);
        if ($event->slots_available <= 0) {
            return false;
        }

        $this->eventRepository->updateSlotsAvailable($eventId);
        $this->updateQueuePosition('event:' . $eventId, $userId);
        return true;
    }
}