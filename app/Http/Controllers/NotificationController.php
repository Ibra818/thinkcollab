<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    /**
     * Helper statique pour créer une notification depuis d'autres contrôleurs
     */
    public static function createNotification(int $userId, string $type, string $title, string $message, ?string $link = null): Notification
    {
        return Notification::create([
            'user_id' => $userId,
            'type' => $type,
            'title' => $title,
            'message' => $message,
            'link' => $link,
        ]);
    }

    public function index()
    {
        $userId = Auth::id();
        $notifications = Notification::where('user_id', $userId)
            ->latest()->limit(200)->get();
        $unread = Notification::where('user_id', $userId)->whereNull('read_at')->count();
        return response()->json(['data' => $notifications, 'unread' => $unread]);
    }

    public function markRead(Notification $notification)
    {
        abort_unless($notification->user_id === Auth::id(), 403);
        if (!$notification->read_at) {
            $notification->read_at = now();
            $notification->save();
        }
        return response()->json(['data' => $notification]);
    }

    public function markAllRead()
    {
        Notification::where('user_id', Auth::id())
            ->whereNull('read_at')
            ->update(['read_at' => now()]);
        return response()->json(['message' => 'all read']);
    }

    // Optional: generic create endpoint for testing
    public function store(Request $request)
    {
        $data = $request->validate([
            'type' => 'required|string',
            'title' => 'required|string|max:255',
            'message' => 'required|string',
            'user_id' => 'nullable|exists:users,id',
            'data' => 'nullable',
        ]);
        $data['user_id'] = $data['user_id'] ?? Auth::id();
        $notification = Notification::create($data);
        return response()->json(['data' => $notification], 201);
    }
}



