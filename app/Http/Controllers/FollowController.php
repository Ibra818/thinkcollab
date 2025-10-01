<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\NotificationController;

class FollowController extends Controller
{
    public function follow(User $user): JsonResponse
    {
        if ($user->id === Auth::id()) {
            return response()->json(['message' => 'Vous ne pouvez pas vous suivre vous-même'], 400);
        }

        $alreadyFollowing = DB::table('follows')
            ->where('follower_id', Auth::id())
            ->where('followed_id', $user->id)
            ->exists();

        if (!$alreadyFollowing) {
            DB::table('follows')->insert([
                'follower_id' => Auth::id(),
                'followed_id' => $user->id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Vérifier si c'est un follow-back
            $isFollowBack = DB::table('follows')
                ->where('follower_id', $user->id)
                ->where('followed_id', Auth::id())
                ->exists();

            // Notification: follow ou follow-back
            NotificationController::createNotification(
                $user->id,
                'follow',
                $isFollowBack ? 'Follow-back' : 'Nouveau follower',
                Auth::user()->name . ($isFollowBack ? ' vous suit également !' : ' vous suit maintenant'),
                '/users/' . Auth::id() . '/profile'
            );
        }

        return response()->json(['message' => 'Utilisateur suivi avec succès']);
    }

    public function unfollow(User $user): JsonResponse
    {
        DB::table('follows')
          ->where('follower_id', Auth::id())
          ->where('followed_id', $user->id)
          ->delete();

        return response()->json(['message' => 'Utilisateur non suivi avec succès']);
    }

    public function followers(User $user): JsonResponse
    {
        $followers = $user->followers()->get();
        return response()->json($followers);
    }

    public function followings(User $user): JsonResponse
    {
        $followings = $user->followings()->get();
        return response()->json($followings);
    }

    public function myFollowers(): JsonResponse
    {
        $followers = Auth::user()->followers()->get();
        return response()->json($followers);
    }

    public function myFollowings(): JsonResponse
    {
        $followings = Auth::user()->followings()->get();
        return response()->json($followings);
    }

    public function isFollowing(User $user): JsonResponse
    {
        $isFollowing = DB::table('follows')
                        ->where('follower_id', Auth::id())
                        ->where('followed_id', $user->id)
                        ->exists();

        return response()->json(['is_following' => $isFollowing]);
    }
}
