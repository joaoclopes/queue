<?php

namespace App\Services;

use App\Abstracts\CustomException;
use App\Exceptions\QueueWaitException;
use App\Exceptions\TicketSoldOutException;
use App\Repositories\EventRepository;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class EventService
{
    public function __construct(protected EventRepository $eventRepository, protected Client $client)
    {
    }

    public function store($data)
    {
        return $this->eventRepository->store($data);
    }

    public function addUserToEvent($data)
    {
        $eventId = $data['event_id'];
        $ticketIsAvailable = $this->checkIfTicketIsAvailable($eventId);
        if (!$ticketIsAvailable) {
            // ingressos esgostados, montar alguma comunicacao com o gerenciador de fila
            // pra rancar a fila e notificar os clientes que ainda estao na fila
            throw new TicketSoldOutException();
        }

        $userCanBuy = $this->checkIfHasQueue($eventId, $data['user_id']);
        if (!$userCanBuy) {
            // fazer o usuario entrar na fila
            throw new QueueWaitException();
        }
        // $this->eventRepository->updateSlotsAvailable($data['event_id']);
        // return $this->eventRepository->addUserToEvent($data);
        return true;
    }

    public function checkIfTicketIsAvailable($eventId)
    {
        $event = $this->eventRepository->getById($eventId);
        return ($event->slots > $event->users()->count());
    }

    public function checkIfHasQueue($eventId, $userId)
    {
        $event = $this->eventRepository->getById($eventId);
        $redisLock = $this->eventRepository->catchAmountOfRegisteringUsers($eventId);
        if (!$redisLock || $redisLock <= $event->slots_available) {
            $this->eventRepository->insertUserInLock($eventId, $userId);
            return true;
        }

        return false;
    }
}