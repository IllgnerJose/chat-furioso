<?php

namespace App\Repositories;
use App\Models\Round;
use App\Models\Game;
use Illuminate\Database\Eloquent\Collection;

class RoundRepository
{
    public Round $roundModel;

    public function __construct(Round $roundModel)
    {
        $this->$roundModel = $roundModel;
    }

    public function createRound(Game $game): Round
    {
        return $game->rounds()->create();
    }

    public function updateRound(Array $validatedData, Round $round): Round
    {
        $round->update($validatedData);
        return $round;
    }
}
