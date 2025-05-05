<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\LoadChatController;
use App\Http\Controllers\LoadGameListController;
use Inertia\Inertia;

Route::get('/chat/{game}', LoadChatController::class)
    ->middleware(['auth', 'verified'])
    ->name('chat');

Route::get('dashboard', LoadGameListController::class)
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::post("message/store", [MessageController::class, 'store'])
    ->middleware(['auth', 'verified'])
    ->name('message.store');

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');


require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
