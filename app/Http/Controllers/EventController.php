<?php

namespace App\Http\Controllers;

use App\Abstracts\CustomException;
use App\Http\Requests\Event\StoreEventRequest;
use App\Http\Requests\Event\StoreEventUserRequest;
use App\Services\EventService;

class EventController
{
    public function __construct(private EventService $eventService)
    {
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

            return response()->json([
                'success' => true,
                'message' => 'O evento foi criado com sucesso!',
            ], 200);
        } catch(CustomException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Ocorreu um erro criar o evento, tente novamente mais tarde! Error: ' . $e->getMessage()
            ], 500);
        }
    }

    public function addUserToEvent(StoreEventUserRequest $request)
    {
        try {
            $data = $request->validated();
            if (!$data) {
                return response()->json([
                    'success' => false,
                    'message' => 'Algum dado invalido, preencha os dados corretamente!'
                ], 400);
            }
            $this->eventService->addUserToEvent($data);

            return response()->json([
                'success' => true,
                'message' => 'O usuario foi inscrito no evento com sucesso!',
            ], 200);
        } catch(CustomException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Ocorreu um erro atrelar o usuario ao evento, tente novamente mais tarde! Error: ' . $e->getMessage()
            ], 500);
        }
        
    }
}