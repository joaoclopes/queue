<?php

use App\Http\Controllers\QueueController;
use App\Http\Controllers\TicketQueueController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::get('/queue', [QueueController::class, 'queue']);

    Route::prefix('queue')->group(function () {
        Route::post('/join', [TicketQueueController::class, 'joinQueue']);
        Route::post('/leave', [TicketQueueController::class, 'leaveQueue']);
        Route::post('/process', [TicketQueueController::class, 'processQueue']);
        Route::get('/{ticketId}', [TicketQueueController::class, 'fetchQueue']);
    });
});
