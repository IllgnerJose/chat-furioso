<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use App\Http\Requests\StoreGameRequest;
use App\Http\Requests\UpdateGameRequest;
use App\Models\Game;
use App\Models\Team;
use App\Services\GameService;

class GameController extends Controller
{
    public $gameService;

    public function __construct(GameService $gameService)
    {
        $this->gameService = $gameService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): Collection
    {
        return $this->gameService->returnAllGames();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreGameRequest $request): Game
    {
        return $this->gameService->storeGame($request->validated());
    }

    /**
     * Display the specified resource.
     */
    public function start(Game $game): Game
    {
        return $this->gameService->startGame($game);
    }

    public function end(Game $game): Game
    {
        return $this->gameService->endGame($game);
    }

    public function win(Team $team, Game $game): Game
    {
        return $this->gameService->winGame($team, $game);
    }
}
