<?php

namespace App\Services;
use App\Models\Comment;
use App\Repositories\CommentRepository;
use App\Models\Round;
use Prism\Prism\Prism;
use Prism\Prism\Enums\Provider;

class CommentService
{
    public CommentRepository $commentRepository;

    public function __construct(CommentRepository $commentRepository)
    {
        $this->commentRepository = $commentRepository;
    }

    public function createComment(Round $round): Comment
    {
        $game = $round->game()->first();

        $team1Name = $game->team1->team;
        $team2Name = $game->team2->team;
        $team1Score = $round->team_1_score;
        $team2Score = $round->team_2_score;

        $score = "$team1Name $team1Score X $team2Score $team2Name";

        $prompt = "Gere um comentário breve para uma partida de Counter-Strike.
        Placar: $score.
        Use no máximo duas frases.";

        $response = Prism::text()
            ->using(Provider::DeepSeek, 'deepseek/deepseek-prover-v2:free')
            ->withPrompt($prompt)
            ->asText();

        $data = [
            "round_id" => $round->id,
            "comment" => $response->text,
        ];

        return $this->commentRepository->storeComment($data);
    }
}
