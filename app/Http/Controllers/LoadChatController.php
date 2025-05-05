<?php

namespace App\Http\Controllers;

use App\Services\ChatService;
use Inertia\Inertia;
use App\Models\Game;

class LoadChatController extends Controller
{
    public $chatService;

    public function __construct(ChatService $chatService)
    {
        $this->chatService = $chatService;
    }

    public function __invoke(Game $game)
    {
        return Inertia::render('ChatLayout', $this->chatService->getChatResources($game));
    }
}
