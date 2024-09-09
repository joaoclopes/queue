<?php

use App\Http\Controllers\QueueController;
use App\Http\Controllers\TicketQueueController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::get('/test', [QueueController::class, 'test']);

    Route::get('/sse', [QueueController::class, 'enterInQueue']);
});
