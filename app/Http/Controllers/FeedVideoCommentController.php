<?php

namespace App\Http\Controllers;

use App\Models\FeedVideo;
use App\Models\FeedVideoComment;
use App\Models\CommentLike;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\NotificationController;

class FeedVideoCommentController extends Controller
{
    public function index(FeedVideo $feedVideo)
    {
        $userId = Auth::id();
        $comments = FeedVideoComment::with(['user:id,name,avatar_url', 'replies.user:id,name,avatar_url', 'likes'])
            ->where('feed_video_id', $feedVideo->id)
            ->whereNull('parent_id')
            ->withCount('likes')
            ->latest()
            ->get();

        // Ajouter is_liked pour chaque commentaire
        $comments->each(function ($comment) use ($userId) {
            $comment->is_liked = $userId ? $comment->likes->contains('user_id', $userId) : false;
            $comment->makeHidden('likes');
            
            // Traiter aussi les réponses
            if ($comment->replies) {
                $comment->replies->each(function ($reply) use ($userId) {
                    $reply->likes_count = $reply->likes()->count();
                    $reply->is_liked = $userId ? $reply->likes()->where('user_id', $userId)->exists() : false;
                });
            }
        });

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

        // Notifications
        // 1) Si réponse à un commentaire, notifier l'auteur du commentaire parent
        if (!empty($validated['parent_id'])) {
            $parent = FeedVideoComment::find($validated['parent_id']);
            if ($parent && $parent->user_id !== Auth::id()) {
                NotificationController::createNotification(
                    $parent->user_id,
                    'comment',
                    'Nouvelle réponse',
                    Auth::user()->name . ' a répondu à votre commentaire',
                    '/feed-videos/' . $feedVideo->id
                );
            }
        } else {
            // 2) Sinon, commentaire sur la vidéo: notifier l'auteur de la vidéo
            if ($feedVideo->user_id !== Auth::id()) {
                NotificationController::createNotification(
                    $feedVideo->user_id,
                    'comment',
                    'Nouveau commentaire',
                    Auth::user()->name . ' a commenté votre vidéo',
                    '/feed-videos/' . $feedVideo->id
                );
            }
        }

        return response()->json(['data' => $comment->load('user:id,name,avatar_url')], 201);
    }

    public function like(FeedVideoComment $comment)
    {
        $userId = Auth::id();
        $existingLike = CommentLike::where('user_id', $userId)
            ->where('feed_video_comment_id', $comment->id)
            ->first();

        if ($existingLike) {
            // Unlike
            $existingLike->delete();
            return response()->json([
                'data' => [
                    'liked' => false,
                    'likes_count' => $comment->likes()->count()
                ]
            ]);
        } else {
            // Like
            CommentLike::create([
                'user_id' => $userId,
                'feed_video_comment_id' => $comment->id,
            ]);

            // Notification: like sur commentaire
            if ($comment->user_id !== $userId) {
                NotificationController::createNotification(
                    $comment->user_id,
                    'like',
                    'Nouveau like',
                    Auth::user()->name . ' a aimé votre commentaire',
                    '/feed-videos/' . $comment->feed_video_id
                );
            }

            return response()->json([
                'data' => [
                    'liked' => true,
                    'likes_count' => $comment->likes()->count()
                ]
            ]);
        }
    }
}
