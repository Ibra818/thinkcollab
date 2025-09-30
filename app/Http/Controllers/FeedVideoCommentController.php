<?php

namespace App\Http\Controllers;

use App\Models\FeedVideo;
use App\Models\FeedVideoComment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FeedVideoCommentController extends Controller
{
    public function index(FeedVideo $feedVideo)
    {
        $comments = FeedVideoComment::with(['user:id,name,email', 'replies.user:id,name,email'])
            ->where('feed_video_id', $feedVideo->id)
            ->whereNull('parent_id')
            ->latest()
            ->get();
        return response()->json(['data' => $comments]);
    }

    public function store(Request $request, FeedVideo $feedVideo)
    {
        $validated = $request->validate([
            'content' => 'required|string|max:4000',
            'parent_id' => 'nullable|exists:feed_video_comments,id'
        ]);
        $comment = FeedVideoComment::create([
            'feed_video_id' => $feedVideo->id,
            'user_id' => Auth::id(),
            'parent_id' => $validated['parent_id'] ?? null,
            'content' => $validated['content'],
        ]);
        return response()->json(['data' => $comment->load('user:id,name,email')], 201);
    }

    public function like(FeedVideoComment $comment)
    {
        $comment->increment('likes_count');
        return response()->json(['data' => ['likes_count' => $comment->likes_count]]);
    }
}


