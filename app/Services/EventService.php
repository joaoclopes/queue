<?php

namespace App\Services;

use App\Abstracts\CustomException;
use App\Repositories\EventRepository;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

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
        $this->eventRepository->updateSlotsAvailable($data['event_id']);
        return $this->eventRepository->addUserToEvent($data);
    }

    public function checkIfTicketIsAvailable($eventId)
    {
        $event = $this->eventRepository->getById($eventId);
        return ($event->slots > $event->users()->count());
    }

    public function checkIfUserCanBuy($eventId)
    {
        
    }

    public function checkQueueEvent($eventId)
    {
        $client = new Client();
        try {
            $response = $client->post(env('ORCHESTRATOR_URL'), [
                'headers' => [
                    'Accept' => 'application/json',
                ],
                'event_id' => $eventId,
            ]);

            return json_decode($response->getBody(), true);
        } catch (CustomException $e) {
            Log::error($e->getMessage());
            return false;
        }
    }
}