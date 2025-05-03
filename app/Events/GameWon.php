<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class GameWon implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $roundStart;
    public $team1Score;
    public $team2Score;
    public $gameRounds;
    public $gameId;

    /**
     * Create a new event instance.
     */
    public function __construct($roundStart, $team1Score, $team2Score, $gameRounds, $gameId)
    {
        $this->roundStart = $roundStart;
        $this->team1Score = $team1Score;
        $this->team2Score = $team2Score;
        $this->gameRounds = $gameRounds;
        $this->gameId = $gameId;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel("game.win.{$this->gameId}"),
        ];
    }
}
