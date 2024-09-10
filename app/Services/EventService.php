<?php

namespace App\Services;

use App\Repositories\EventRepository;

class EventService
{
    public function __construct(private EventRepository $eventRepository, private QueueService $queueService)
    {
    }

    public function store($data)
    {
        return $this->eventRepository->store($data);
    }

    public function addUserToEvent($data)
    {
        $this->queueService->updateQueuePosition('event:' . $data['event_id'], $data['user_id']);
        $this->eventRepository->updateSlotsAvailable($data['event_id']);
        return $this->eventRepository->addUserToEvent($data);
    }
}