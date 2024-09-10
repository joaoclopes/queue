<?php

namespace App\Services;

use App\Repositories\EventRepository;

class EventService
{
    public function __construct(private EventRepository $eventRepository)
    {
    }

    public function store($data)
    {
        return $this->eventRepository->store($data);
    }

    public function addUserToEvent($data)
    {
        return $this->eventRepository->addUserToEvent($data);
    }
}