<?php

namespace App\Policies;

use App\Models\FeedVideo;
use App\Models\User;

class FeedVideoPolicy
{
    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->role === 'formateur';
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, FeedVideo $feedVideo): bool
    {
        return $user->id === $feedVideo->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, FeedVideo $feedVideo): bool
    {
        return $user->id === $feedVideo->user_id;
    }
}
