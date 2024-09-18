<?php

namespace App\Http\Controllers;

use App\Abstracts\CustomException;
use App\Http\Requests\Event\CheckEventStatusRequest;
use App\Http\Requests\Event\StoreEventRequest;
use App\Http\Requests\Event\StoreEventUserRequest;
use App\Services\EventService;

class EventController
{
    public function __construct(private EventService $eventService)
    {
    }

    public function index()
    {
        $events = $this->eventService->getAll();
        return view('events.index', compact('events'));
    }

    public function store(StoreEventRequest $request)
    {
        try {
            $data = $request->validated();
            if (!$data) {
                return response()->json([
                    'success' => false,
                    'message' => 'Ocorreu um erro criar o evento, preencha os dados corretamente!'
                ], 400);
            }
            $this->eventService->store($data);

            return redirect()->route('events.index');
        } catch (CustomException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Ocorreu um erro criar o evento, tente novamente mais tarde! Error: ' . $e->getMessage()
            ], 500);
        }
    }
}
