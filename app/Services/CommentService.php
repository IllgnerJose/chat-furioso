<?php

namespace App\Services;
use App\Models\Comment;
use App\Models\Game;
use App\Repositories\CommentRepository;
use App\Models\Round;
use App\Repositories\RoundRepository;
use Carbon\Carbon;
use Prism\Prism\Prism;
use Prism\Prism\Enums\Provider;
use App\Events\CommentReceived;
use Illuminate\Support\Collection;

class CommentService
{
    public CommentRepository $commentRepository;
    public RoundRepository $roundRepository;

    public function __construct(CommentRepository $commentRepository, RoundRepository $roundRepository)
    {
        $this->commentRepository = $commentRepository;
        $this->roundRepository = $roundRepository;
    }

    public function createComment(Round $round): Comment
    {
        $game = $round->game()->first();

        $team1Name = $game->team1->team;
        $team2Name = $game->team2->team;
        $team1Score = $round->team_1_score;
        $team2Score = $round->team_2_score;

        $score = "$team1Name $team1Score X $team2Score $team2Name";

        $prompt = "Gere um comentário breve para um round de Counter-Strike.
        Placar: $score.
        Use no máximo duas frases. Sempre em Português do Brasil";

        $response = Prism::text()
            ->using(Provider::DeepSeek, 'deepseek/deepseek-prover-v2:free')
            ->withPrompt($prompt)
            ->asText();

        $data = [
            "round_id" => $round->id,
            "comment" => $response->text,
        ];

        $comment = $this->commentRepository->storeComment($data);

        CommentReceived::dispatch($comment->id, $comment->comment, $comment->round->round_end, $game->id);
        return $comment;

    }

    public function formatComment(Comment $comment): array
    {
        return [
            "id"=>$comment->id,
            "comment"=>$comment->comment,
            'comment_round_time' => Carbon::parse($comment->round->round_end)->format('d.m.Y H:i:s'),
        ];
    }

    public function getFormatedComments(Game $game): array
    {
        return ($this->roundRepository->getRoundPerGame($game)
            ->flatMap(
                fn($round) => $this->commentRepository
                    ->getCommentsPerRound($round)
                    ->map(fn($comment) => $this->formatComment($comment))
            )
        )->toArray();
    }
}
