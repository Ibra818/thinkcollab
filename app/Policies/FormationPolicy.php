<?php

namespace App\Policies;

use App\Models\Formation;
use App\Models\User;
use App\Models\Purchase;
use Illuminate\Auth\Access\Response;

class FormationPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Formation $formation): bool
    {
        return true;
    }

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
    public function update(User $user, Formation $formation): bool
    {
        return $user->id === $formation->formateur_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Formation $formation): bool
    {
        return $user->id === $formation->formateur_id;
    }

    /**
     * Determine whether the user can view lesson videos.
     */
    public function viewLessons(User $user, Formation $formation): bool
    {
        // Le formateur peut toujours voir ses vidéos
        if ($user->id === $formation->formateur_id) {
            return true;
        }

        // L'apprenant doit avoir acheté la formation
        return Purchase::where('user_id', $user->id)
                      ->where('formation_id', $formation->id)
                      ->where('status', 'paid')
                      ->exists();
    }
}
