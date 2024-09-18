<?php

use App\Http\Controllers\BatchController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\FormController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::prefix('user')->group(function () {
        Route::post('/', [UserController::class, 'store'])->name('createUser');
        Route::get('/', [UserController::class, 'getAll']);
    });

    Route::prefix('event')->group(function () {
        Route::post('/', [EventController::class, 'store'])->name('createEvent');
        Route::get('/piroca', [EventController::class, 'getAll']);
    });
    
    Route::prefix('batch')->group(function () {
        Route::post('/', [BatchController::class, 'store'])->name('createBatch');
        Route::get('/', [BatchController::class, 'getAll']);
        Route::get('/{batchId}', [BatchController::class, 'getById']);
        Route::get('/event/{eventId}', [BatchController::class, 'getBatchesByEvent']);
        Route::post('/buy', [BatchController::class, 'buyBatch'])->name('buyBatch');
        Route::post('/status', [BatchController::class, 'checkBatchStatus']);
    });

    Route::post('/submit', [FormController::class, 'submit'])->name('form.submit');
});
