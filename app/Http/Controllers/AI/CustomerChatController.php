<?php

namespace App\Http\Controllers\AI;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\AI\CustomerChatService;

class CustomerChatController extends Controller
{
    protected CustomerChatService $chatService;

    public function __construct(CustomerChatService $chatService)
    {
        $this->chatService = $chatService;
    }

    public function chat(Request $request)
    {
        $request->validate([
            'message' => 'required|string',
        ]);

        $message = $request->input('message');

        $reply = $this->chatService->handleUserMessage($message, $request);

        return response()->json([
            'reply' => $reply
        ]);
    }
}
