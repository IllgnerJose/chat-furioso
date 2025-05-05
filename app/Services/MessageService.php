<?php

namespace App\Services;
use App\Events\MessageReceived;
use App\Models\Game;
use App\Models\Message;
use App\Repositories\MessageRepository;
use Illuminate\Support\Collection;

class MessageService
{
    public MessageRepository $messageRepository;

    public function __construct(MessageRepository $messageRepository)
    {
        $this->messageRepository = $messageRepository;
    }

    public function formatMessage(Message $message): array
    {
        return [
            "id"=>$message->id,
            "message"=>$message->message,
            "game_id"=>$message->game_id,
            "who"=>$message->user->name,
        ];
    }

    public function getFormatedMessages(Game $game): array
    {
        return $this->messageRepository
            ->getMessagesPerGame($game)
            ->map(fn($message) => $this->formatMessage($message))
            ->toArray();
    }

    public function storeMessage(Array $validatedData): Message
    {
        $message = $this->messageRepository->storeMessage($validatedData);
        broadcast(new MessageReceived($validatedData["id"], $message->message, $validatedData["game_id"]))->toOthers();
        return $message;
    }
}
