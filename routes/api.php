<?php

use App\Http\Controllers\GameController;
use Illuminate\Support\Facades\Route;

Route::apiResources([
   "games" => GameController::class,
]);

Route::get('games/start/{game}', [GameController::class ,"start"])
    ->name("games.start");

Route::get('games/end/{game}', [GameController::class ,"end"])
    ->name("games.end");

Route::get('games/team/{team}/win/{game}', [GameController::class ,"win"])
    ->name("games.win");
