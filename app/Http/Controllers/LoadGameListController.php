<?php

namespace App\Http\Controllers;

use App\Services\GameService;

class LoadGameListController extends Controller
{
    public $gameService;

    public function __construct(GameService $gameService)
    {
        $this->gameService = $gameService;
    }

    public function __invoke()
    {
        return Inertia('GameList', $this->gameService->getGamesPerStatus());
    }
}
