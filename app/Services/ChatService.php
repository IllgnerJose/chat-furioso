<?php

namespace App\Services;
use App\Models\Game;
use App\Services\GameService;
use App\Services\MessageService;
use App\Services\CommentService;
class ChatService
{
    public $gameService;
    public $messageService;
    public $commentService;

    public function __construct(GameService $gameService, MessageService $messageService, CommentService $commentService)
    {
        $this->gameService = $gameService;
        $this->messageService = $messageService;
        $this->commentService = $commentService;
    }

    public function getChatResources(Game $game): array
    {
        return [
            'messages' => $this->messageService->getFormatedMessages($game),
            'game' => $this->gameService->formatGame($game),
            'comments' => $this->commentService->getFormatedComments($game),
        ];
    }
}
