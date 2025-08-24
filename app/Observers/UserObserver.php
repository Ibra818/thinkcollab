<?php

namespace App\Observers;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserObserver
{
    /**
     * Handle the User "creating" event.
     */
    public function creating(User $user): void
    {
        // Hash le mot de passe si ce n'est pas déjà fait
        if (!empty($user->password) && !Hash::needsRehash($user->password)) {
            $user->password = Hash::make($user->password);
        }
    }

    /**
     * Handle the User "updating" event.
     */
    public function updating(User $user): void
    {
        // Hash le mot de passe s'il a été modifié
        if ($user->isDirty('password') && !empty($user->password)) {
            $user->password = Hash::make($user->password);
        }
    }
}
