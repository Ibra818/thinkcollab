<?php

namespace App\Policies;

use App\Models\User;

class UserProfilePolicy
{
    /**
     * Determine whether the user can view the profile.
     */
    public function view(User $user, User $profile): bool
    {
        // Tout le monde peut voir les profils publics
        return true;
    }

    /**
     * Determine whether the user can update the profile.
     */
    public function update(User $user, User $profile): bool
    {
        return $user->id === $profile->id;
    }

    /**
     * Determine whether the user can view private profile data.
     */
    public function viewPrivateData(User $user, User $profile): bool
    {
        return $user->id === $profile->id;
    }
}
