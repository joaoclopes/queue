<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/form', function () {
    return view('ticket');
})->name('form');

Route::get('/queue', function () {
    return view('queue');
})->name('queue');