<?php

namespace App\Policies;

use App\Models\Inscription;
use App\Models\User;

class InscriptionPolicy
{
    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Inscription $inscription): bool
    {
        return $user->id === $inscription->user_id;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Inscription $inscription): bool
    {
        return $user->id === $inscription->user_id;
    }
}
