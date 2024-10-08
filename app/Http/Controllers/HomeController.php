<?php

namespace App\Http\Controllers;

use App\Services\EventService;
use App\Services\UserService;

class HomeController extends Controller
{
    public function __construct(private UserService $userService, private EventService $eventService)
    {
    }

    public function index()
    {
        $events = $this->eventService->getAll();
        $users = $this->userService->getAll();
        
        return view('home', compact('users', 'events'));
    }

    public function queue($batchId, $userId)
    {
        return view('queue.index', compact('batchId', 'userId'));
    }

    public function buy()
    {
        return view('buy.index');
    }
}
