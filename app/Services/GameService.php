<?php

namespace App\Services;
use App\Models\Game;
use Illuminate\Database\Eloquent\Collection;
use App\Repositories\GameRepository;
use App\Enums\GameStatus;
use App\Models\Team;
use App\Events\GameStarted;
use App\Events\GameWon;

class GameService
{
    public GameRepository $gameRepository;

    public function __construct(GameRepository $gameRepository)
    {
        $this->gameRepository = $gameRepository;
    }

    public function returnAllGames(): Collection
    {
        return $this->gameRepository->returnAllGames();
    }

    public function storeGame(Array $validatedData): Game
    {
        return $this->gameRepository->storeGame($validatedData);
    }

    public function startGame(Game $game): Game
    {
        $data = [
          "status" => GameStatus::InProgress->value,
          "game_start" => now(),
          "rounds" => 1,
        ];

        $game = $this->gameRepository->updateGame($data, $game);

        GameStarted::dispatch($game->game_start, $game->rounds, $game->id, $game->status);
        return $game;

    }

    public function endGame(Game $game): Game
    {
        $data = [
            "status" => GameStatus::Finished->value,
            "game_end" => now(),
        ];

        return $this->gameRepository->updateGame($data, $game);
    }

    public function winGame(Team $team, Game $game): Game
    {
        if ($team->id == $game->team_1_id) {
            $data = [
                "rounds" => $game->rounds + 1,
                "team_1_score" => $game->team_1_score + 1,
            ];
        } elseif ($team->id == $game->team_2_id) {
            $data = [
                "rounds" => $game->rounds + 1,
                "team_2_score" => $game->team_2_score + 1,
            ];
        };

        if (isset($data)) {
            $game = $this->gameRepository->updateGame($data, $game);
            GameWon::dispatch($game->team_1_score, $game->team_2_score, $game->rounds, $game->id);
        };

        return $game;
    }
}
