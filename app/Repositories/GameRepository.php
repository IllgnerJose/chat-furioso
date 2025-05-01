<?php

namespace App\Repositories;
use App\Models\Game;
use Illuminate\Database\Eloquent\Collection;

class GameRepository
{
    public Game $gameModel;

    public function __construct(Game $gameModel)
    {
        $this->gameModel = $gameModel;
    }

    public function returnAllGames(): Collection
    {
        return $this->gameModel->all();
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
}
