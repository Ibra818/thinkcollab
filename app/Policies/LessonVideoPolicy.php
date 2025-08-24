<?php

namespace App\Policies;

use App\Models\LessonVideo;
use App\Models\User;
use App\Models\Purchase;

class LessonVideoPolicy
{
    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, LessonVideo $lessonVideo): bool
    {
        // Le formateur peut toujours voir ses vidéos
        if ($user->id === $lessonVideo->formation->formateur_id) {
            return true;
        }

        // L'apprenant doit avoir acheté la formation
        return Purchase::where('user_id', $user->id)
                      ->where('formation_id', $lessonVideo->formation_id)
                      ->where('status', 'paid')
                      ->exists();
    }
}
