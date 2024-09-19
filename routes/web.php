<?php

use App\Http\Controllers\BatchController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

route::get('/queue/{batchId}/{userId}', [HomeController::class, 'queue'])->name('queue');

route::get('/buy', [HomeController::class, 'buy'])->name('buy');

route::get('/', [HomeController::class, 'index'])->name('home');

route::get('/users', [UserController::class, 'index'])->name('users.index');

route::get('/events', [EventController::class, 'index'])->name('events.index');

route::get('/batches', [BatchController::class, 'index'])->name('batches.index');