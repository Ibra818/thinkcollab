<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function index(): JsonResponse
    {
        $messages = Message::with(['sender', 'receiver'])
                           ->where(function ($query) {
                               $query->where('sender_id', Auth::id())
                                     ->orWhere('receiver_id', Auth::id());
                           })
                           ->orderBy('sent_at', 'desc')
                           ->get();

        return response()->json($messages);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'contenu' => 'required|string',
        ]);

        $validated['sender_id'] = Auth::id();
        $validated['sent_at'] = now();

        $message = Message::create($validated);
        return response()->json($message->load(['sender', 'receiver']), 201);
    }

    public function show(Message $message): JsonResponse
    {
        $this->authorize('view', $message);
        return response()->json($message->load(['sender', 'receiver']));
    }

    public function markAsRead(Message $message): JsonResponse
    {
        $this->authorize('markAsRead', $message);
        
        $message->update(['read_at' => now()]);
        return response()->json($message);
    }

    public function getConversation(User $user): JsonResponse
    {
        $messages = Message::with(['sender', 'receiver'])
                           ->where(function ($query) use ($user) {
                               $query->where('sender_id', Auth::id())
                                     ->where('receiver_id', $user->id);
                           })
                           ->orWhere(function ($query) use ($user) {
                               $query->where('sender_id', $user->id)
                                     ->where('receiver_id', Auth::id());
                           })
                           ->orderBy('sent_at', 'asc')
                           ->get();

        // Marquer les messages reçus comme lus
        Message::where('sender_id', $user->id)
               ->where('receiver_id', Auth::id())
               ->whereNull('read_at')
               ->update(['read_at' => now()]);

        return response()->json($messages);
    }

    public function getUnreadCount(): JsonResponse
    {
        $count = Message::where('receiver_id', Auth::id())
                        ->whereNull('read_at')
                        ->count();

        return response()->json(['unread_count' => $count]);
    }
}
