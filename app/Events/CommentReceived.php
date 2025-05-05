<?php

namespace App\Events;

use Carbon\Carbon;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CommentReceived implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $id;
    public $comment;
    public $commentRoundTime;
    public $gameId;

    /**
     * Create a new event instance.
     */
    public function __construct($id, $comment, $commentRoundTime, $gameId)
    {
        $this->id = $id;
        $this->comment = $comment;
        $this->commentRoundTime = Carbon::parse($commentRoundTime)->format('d.m.Y H:i:s');
        $this->gameId = $gameId;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): Channel
    {
        return new PrivateChannel("comments.game.{$this->gameId}");
    }
}
