<?php

namespace App\Repositories;

use App\Models\Event;

class EventRepository
{
    public function __construct(private UserRepository $userRepository)
    {
    }

    public function store($data)
    {
        return Event::create($data);
    }

    public function addUserToEvent($data)
    {
        $event = Event::find($data['event_id']);
        $user = $this->userRepository->getUserById($data['user_id']);

        return $event->users()->attach($user->id);
    }

    public function getById($eventId)
    {
        return Event::find($eventId);
    }

    public function updateSlotsAvailable($eventId)
    {
        $event = $this->getById($eventId);
        $event->slots_available -= 1;
        $event->save();
        return $event;
    }
}