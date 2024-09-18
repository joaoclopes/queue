<?php

namespace App\Repositories;

use App\Models\Event;
use Illuminate\Support\Facades\Redis;

class EventRepository
{
    public function __construct(private UserRepository $userRepository)
    {
    }

    public function getAll()
    {
        return Event::all();
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

    public function catchAmountOfRegisteringUsers($eventId)
    {
        return Redis::get('lock_event:' . $eventId);
    }

    public function insertUserInLock($eventId)
    {
        $redisKey = 'lock_event:' . $eventId;
        Redis::incr($redisKey);
    }
}