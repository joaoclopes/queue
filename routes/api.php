<?php

use App\Http\Controllers\EventController;
use App\Http\Controllers\FormController;
use App\Http\Controllers\QueueController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::prefix('user')->group(function () {
        Route::post('/', [UserController::class, 'store']);
    });

    Route::prefix('event')->group(function () {
        Route::post('/', [EventController::class, 'store']);
        Route::post('/user', [EventController::class, 'addUserToEvent']);
    });

    Route::prefix('queue')->group(function () {
        Route::get('/status', [QueueController::class, 'queueStatus']);
        Route::post('/enter', [QueueController::class, 'getInQueue']);
    });

    Route::post('/submit', [FormController::class, 'submit'])->name('form.submit');
});
