<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use App\Models\Message;
use App\Events\MessageReceived;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class MessageController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            "message" => "string|required",
            "id" => "required",
            "game_id" => "required"
        ]);

        $message = auth()->user()->message()->create([
            "message" => $data["message"],
            "game_id" => $data["game_id"]
        ]);

        broadcast(new MessageReceived($data["id"], $message->message, $data["game_id"]))->toOthers();
        return response()->json([
            "status" => "success",
            "message" => "Message received!",
        ], 200);
    }
}
