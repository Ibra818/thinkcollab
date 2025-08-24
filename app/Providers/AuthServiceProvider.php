<?php

namespace App\Providers;

use App\Models\Formation;
use App\Models\LessonVideo;
use App\Models\Purchase;
use App\Models\Inscription;
use App\Models\FeedVideo;
use App\Models\Message;
use App\Models\FavoriVideo;
use App\Policies\FormationPolicy;
use App\Policies\LessonVideoPolicy;
use App\Policies\PurchasePolicy;
use App\Policies\InscriptionPolicy;
use App\Policies\FeedVideoPolicy;
use App\Policies\MessagePolicy;
use App\Policies\FavoriVideoPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Formation::class => FormationPolicy::class,
        LessonVideo::class => LessonVideoPolicy::class,
        Purchase::class => PurchasePolicy::class,
        Inscription::class => InscriptionPolicy::class,
        FeedVideo::class => FeedVideoPolicy::class,
        Message::class => MessagePolicy::class,
        FavoriVideo::class => FavoriVideoPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        // Gate pour vérifier l'accès aux vidéos de cours
        Gate::define('canViewLesson', function ($user, $lessonVideo) {
            // Le formateur peut toujours voir ses vidéos
            if ($user->id === $lessonVideo->formation->formateur_id) {
                return true;
            }

            // L'apprenant doit avoir acheté la formation
            return Purchase::where('user_id', $user->id)
                          ->where('formation_id', $lessonVideo->formation_id)
                          ->where('status', 'paid')
                          ->exists();
        });
    }
}
