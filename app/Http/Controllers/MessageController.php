<?php

namespace App\Http\Controllers;

use App\Events\MessageReceived;
use Illuminate\Http\JsonResponse;
use App\Services\MessageService;
use App\Http\Requests\StoreMessageRequest;

class MessageController extends Controller
{
    public MessageService $messageService;

    public function __construct(MessageService $messageService)
    {
        $this->messageService = $messageService;
    }

    public function store(StoreMessageRequest $request): JsonResponse
    {
        $data = $request->validated();

        $this->messageService->storeMessage($data);

        return response()->json([
            "status" => "success",
            "message" => "Message received!",
        ], 200);
    }
}
