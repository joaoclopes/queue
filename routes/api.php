<?php

use App\Http\Controllers\FormController;
use App\Http\Controllers\QueueController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::get('/test', [QueueController::class, 'test']);

    Route::get('/sse', [QueueController::class, 'enterInQueue']);

    Route::post('/submit', [FormController::class, 'submit'])->name('form.submit');
});
