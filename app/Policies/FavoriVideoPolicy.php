<?php

namespace App\Policies;

use App\Models\FavoriVideo;
use App\Models\User;

class FavoriVideoPolicy
{
    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, FavoriVideo $favoriVideo): bool
    {
        return $user->id === $favoriVideo->user_id;
    }
}
