<?php

namespace App\Services;
use App\Models\Game;
use App\Repositories\RoundRepository;
use App\Services\CommentService;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use App\Repositories\GameRepository;
use App\Enums\GameStatus;
use App\Models\Team;
use App\Events\GameStarted;
use App\Events\GameWon;

class GameService
{
    public GameRepository $gameRepository;
    public RoundRepository $roundRepository;

    public CommentService $commentService;

    public function __construct(GameRepository $gameRepository, RoundRepository $roundRepository, CommentService $commentService)
    {
        $this->gameRepository = $gameRepository;
        $this->roundRepository = $roundRepository;
        $this->commentService = $commentService;
    }

    public function returnAllGames(): Collection
    {
        return $this->gameRepository->returnAllGames();
    }

    public function storeGame(Array $validatedData): Game
    {
        $game = $this->gameRepository->storeGame($validatedData);
        $this->roundRepository->createRound($game);
        return $game;
    }

    public function startGame(Game $game): Game
    {
        //Inicia a Partida
        $data = [
          "status" => GameStatus::InProgress->value,
          "game_start" => now(),
        ];
        $game = $this->gameRepository->updateGame($data, $game);

        //Inicia o Round
        $data = [
            "round_start" => now(),
        ];
        $currentRound = $game->rounds()->latest()->first();
        $this->roundRepository->updateRound($data, $currentRound);

        GameStarted::dispatch($currentRound->round_start, count($game->rounds()->get()), $game->id, $game->status);
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
        //Recebe o round atual
        $currentRound = $game->rounds()->latest()->first();

        //Verifica qual time marcou o ponto
        if ($team->id == $game->team_1_id) {
            $data = [
                "round_end" => now(),
                "team_1_score" => $currentRound->team_1_score + 1,
            ];
        } elseif ($team->id == $game->team_2_id) {
            $data = [
                "round_end" => now(),
                "team_2_score" => $currentRound->team_2_score + 1,
            ];
        };

        //Inicia uma nova rodada e salva um comentário sobre a antiga
        if (isset($data)) {
            $oldRound = $this->roundRepository->updateRound($data, $currentRound);

            $newRound = $this->roundRepository->createRound($game);
            $newData = [
                "team_1_score" => $oldRound->team_1_score,
                "team_2_score" => $oldRound->team_2_score,
                "round_start" => now(),
            ];
            $this->roundRepository->updateRound($newData, $newRound);

            GameWon::dispatch($newRound->round_start, $newRound->team_1_score, $newRound->team_2_score, count($game->rounds()->get()), $game->id);

            $this->commentService->createComment($oldRound);
        };

        return $game;
    }

    public function formatGame(Game $game): array
    {
        $lastRound = $game->rounds->last();

        return [
            "id" => $game->id,
            "team_1" => $game->team1->team,
            "team_2" => $game->team2->team,
            "team_1_score" => $lastRound?->team_1_score,
            "team_2_score" => $lastRound?->team_2_score,
            "team_1_logo" => $game->team1->logo_path,
            "team_2_logo" => $game->team2->logo_path,
            "game_status" => $game->status,
            "game_start" => $game->game_start,
            "game_date" => Carbon::parse($game->game_date)->format('d.m.Y H:i:s'),
            "round_start"=>$lastRound->round_start,
            "game_rounds"=>count($game->rounds()->get()),
        ];
    }

    public function getGamesPerStatus(): array
    {
        return [
            'nextGames' => ($this->gameRepository->getGamesByStatus(GameStatus::Scheduled)?->map(fn($game) => $this->formatGame($game))) ?? [],
            'inProgressGames' => ($this->gameRepository->getGamesByStatus(GameStatus::InProgress)?->map(fn($game) => $this->formatGame($game))) ?? [],
            'finishedGames' => ($this->gameRepository->getGamesByStatus(GameStatus::Finished)?->map(fn($game) => $this->formatGame($game))) ?? [],
        ];
    }
}
