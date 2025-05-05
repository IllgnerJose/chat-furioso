<?php

namespace App\Repositories;
use App\Models\Game;
use Illuminate\Database\Eloquent\Collection;
use App\Enums\GameStatus;

class GameRepository
{
    public Game $gameModel;

    public function __construct(Game $gameModel)
    {
        $this->gameModel = $gameModel;
    }

    public function returnAllGames(): Collection
    {
        return $this->gameModel
            ->with(['team1', 'team2', 'rounds'])
            ->get();
    }

    public function storeGame(Array $validatedData): Game
    {
        return $this->gameModel->create($validatedData);
    }

    public function updateGame(Array $validatedData, Game $game): Game
    {
        $game->update($validatedData);
        return $game;
    }

    public function getGamesByStatus(GameStatus $status): Collection
    {
       return $this->gameModel->with(['team1', 'team2', 'rounds'])
           ->where("status", $status->value)
           ->get();
    }
}
