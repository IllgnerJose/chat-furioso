<?php

use Illuminate\Support\Facades\Route;
use App\Events\MessageReceived;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\LoadChatController;
use Inertia\Inertia;
use App\Models\Message;
use App\Models\Game;

Route::get('/chat/{game}', LoadChatController::class)->name('chat');

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard', [
        'games' => Game::all()->map(function ($game){
            return [
                "id"=>$game->id,
                "team_1"=>$game->team1->team,
                "team_2"=>$game->team2->team,
                "team_1_score"=>$game->rounds()->latest()->first()->team_1_score,
                "team_2_score"=>$game->rounds()->latest()->first()->team_2_score,
                "team_1_logo"=>$game->team1->logo_path,
                "team_2_logo"=>$game->team2->logo_path,
                "game_status"=>$game->status,
                "game_start"=>$game->game_start,
            ];
        }),
    ]);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::post("message/store", [MessageController::class, 'store'])
    ->middleware(['auth', 'verified'])
    ->name('message.store');

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
