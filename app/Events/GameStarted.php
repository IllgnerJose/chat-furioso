<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class GameStarted implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $roundStart;
    public $gameRounds;
    public $gameId;

    public $gameStatus;

    /**
     * Create a new event instance.
     */
    public function __construct($roundStart, $gameRounds, $gameId, $gameStatus)
    {
        $this->roundStart = $roundStart;
        $this->gameRounds = $gameRounds;
        $this->gameId = $gameId;
        $this->gameStatus = $gameStatus;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel("game.start.{$this->gameId}"),
        ];
    }
}
