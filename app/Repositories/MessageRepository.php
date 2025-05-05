<?php

namespace App\Repositories;
use App\Models\Game;
use Illuminate\Database\Eloquent\Collection;
use App\Models\Message;

class MessageRepository
{
    public Message $messageModel;

    public function __construct(Message $messageModel)
    {
        $this->messageModel = $messageModel;
    }

    public function getMessagesPerGame(Game $game): Collection
    {
        return $game
            ->messages()
            ->with(['user', 'game'])
            ->get();
    }

    public function storeMessage(Array $validatedData): Message
    {
        return auth()->user()->message()->create($validatedData);
    }
}
