<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Message;
use App\Models\Game;

class LoadChatController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Game $game)
    {
        return Inertia::render('ChatLayout', [
            'messages' => $game->messages()->get()->map(function ($message){
                return [
                    "id"=>$message->id,
                    "message"=>$message->message,
                    "game_id"=>$message->game_id,
                    "who"=>$message->user->name,
                ];
            }),
            'game' => [
                "id"=>$game->id,
                "team_1"=>$game->team1->team,
                "team_2"=>$game->team2->team,
                "team_1_score"=>$game->rounds()->latest()->first()->team_1_score,
                "team_2_score"=>$game->rounds()->latest()->first()->team_2_score,
                "team_1_logo"=>$game->team1->logo_path,
                "team_2_logo"=>$game->team2->logo_path,
                "game_status"=>$game->status,
                "game_start"=>$game->game_start,
                "game_rounds"=>count($game->rounds()->get()),
            ],
        ]);
    }
}
