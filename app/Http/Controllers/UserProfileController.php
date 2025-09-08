<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Formation;
use App\Models\Inscription;
use App\Models\FavoriVideo;
use App\Models\LessonVideo;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UserProfileController extends Controller
{
    /**
     * Récupérer le profil de l'utilisateur connecté
     */
    public function myProfile(): JsonResponse
    {
        $user = Auth::user();
        
        // Charger les relations nécessaires
        $user->load([
            'followers',
            'followings',
            'inscriptions.formation.formateur',
            'inscriptions.progressions',
            'favoriVideos.lessonVideo.formation'
        ]);

        // Calculer les statistiques
        $profileCompletion = $this->calculateProfileCompletion($user);
        $stats = $this->getUserStats($user);

        return response()->json([
            'user' => $user,
            'profile_completion' => $profileCompletion,
            'stats' => $stats,
        ]);
    }

    /**
     * Récupérer le profil d'un utilisateur spécifique
     */
    public function show(User $user): JsonResponse
    {
        $user->load([
            'followers',
            'followings',
            'formations' => function($query) {
                $query->where('statut', 'published');
            }
        ]);

        $isFollowing = Auth::check() ? 
            Auth::user()->followings()->where('followed_id', $user->id)->exists() : false;

        return response()->json([
            'user' => $user,
            'is_following' => $isFollowing,
            'stats' => $this->getUserStats($user),
        ]);
    }

    /**
     * Mettre à jour le profil utilisateur
     */
    public function update(Request $request): JsonResponse
    {
        $user = $request -> user();
        
        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'bio' => 'sometimes|string|max:1000',
            'avatar' => 'sometimes|image|mimes:jpeg,png,jpg,gif|max:2048',
            'cover_url' => 'sometimes|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Gérer l'upload d'avatar
        if ($request->file('avatar')) {
            // Supprimer l'ancien avatar s'il existe
            if ($user->avatar_url) {
                Storage::disk('public')->delete($user->avatar_url);
            }
            
            $avatarPath = $request->file('avatar')->store('avatars', 'public');
            $validated['avatar_url'] = '/'.$avatarPath;
            unset($validated['avatar']);
            $user->update($validated);

            return response()->json([
            'user' => $user,
            'profile_completion' => $this->calculateProfileCompletion($user),
            'message' => 'Profil mis à jour avec succès'
        ]);
        }

        if ($request->file('cover')) {
            // Supprimer l'ancien avatar s'il existe
            if ($user->cover_url) {
                Storage::disk('public')->delete($user->cover_url);
            }
            
            $coverPath = $request->file('cover')->store('cover', 'public');
            $validated['cover_url'] = '/'.$coverPath;
            unset($validated['cover_url']);

            $user->update($validated);

            return response()->json([
            'user' => $user,
            'profile_completion' => $this->calculateProfileCompletion($user),
            'message' => 'Couverture mis à jour avec succès'
        ]);
        }

    }

    /**
     * Récupérer les cours suivis de l'utilisateur
     */
    public function getEnrolledCourses(): JsonResponse
    {
        $inscriptions = Inscription::with([
            'formation.formateur:id,name,avatar_url',
            'formation.categorie:id,nom',
            'progressions.lessonVideo'
        ])
        ->where('user_id', Auth::id())
        ->get();

        // Calculer la progression pour chaque formation
        $coursesWithProgress = $inscriptions->map(function ($inscription) {
            $totalVideos = $inscription->formation->lessonVideos()->count();
            $completedVideos = $inscription->progressions()->where('pourcentage', 100)->count();
            $overallProgress = $totalVideos > 0 ? ($completedVideos / $totalVideos) * 100 : 0;

            return [
                'inscription' => $inscription,
                'formation' => $inscription->formation,
                'total_videos' => $totalVideos,
                'completed_videos' => $completedVideos,
                'progress_percentage' => round($overallProgress, 2),
                'last_watched' => $inscription->progressions()
                    ->orderBy('last_seen_at', 'desc')
                    ->first()?->last_seen_at,
            ];
        });

        return response()->json($coursesWithProgress);
    }

    /**
     * Récupérer les vidéos favorites de l'utilisateur
     */
    public function getFavoriteVideos(): JsonResponse
    {
        $favorites = FavoriVideo::with([
            'lessonVideo.formation.formateur:id,name,avatar_url',
            'lessonVideo.formation.categorie:id,nom'
        ])
        ->where('user_id', Auth::id())
        ->orderBy('created_at', 'desc')
        ->get();

        return response()->json($favorites);
    }

    /**
     * Récupérer les derniers cours suivis
     */
    public function getRecentCourses(): JsonResponse
    {
        $recentCourses = Inscription::with([
            'formation.formateur:id,name,avatar_url',
            'formation.categorie:id,nom',
            'progressions' => function($query) {
                $query->orderBy('last_seen_at', 'desc')->limit(1);
            }
        ])
        ->where('user_id', Auth::id())
        ->whereHas('progressions')
        ->orderByDesc(function($query) {
            $query->select('last_seen_at')
                  ->from('progressions')
                  ->whereColumn('inscription_id', 'inscriptions.id')
                  ->orderBy('last_seen_at', 'desc')
                  ->limit(1);
        })
        ->limit(10)
        ->get();

        return response()->json($recentCourses);
    }

    /**
     * Calculer le pourcentage de complétion du profil
     */
    private function calculateProfileCompletion(User $user): int
    {
        $fields = [
            'name' => !empty($user->name),
            'email' => !empty($user->email),
            'bio' => !empty($user->bio),
            'avatar_url' => !empty($user->avatar_url),
            'email_verified_at' => !empty($user->email_verified_at),
        ];

        $completedFields = array_filter($fields);
        $completion = (count($completedFields) / count($fields)) * 100;

        return round($completion);
    }

    /**
     * Calculer les statistiques de l'utilisateur
     */
    private function getUserStats(User $user): array
    {
        $stats = [
            'followers_count' => $user->followers()->count(),
            'followings_count' => $user->followings()->count(),
            'inscriptions_count' => $user->inscriptions()->count(),
            'favorites_count' => $user->favoriVideos()->count(),
        ];

        // Statistiques spécifiques aux formateurs
        if ($user->role === 'formateur') {
            $stats['formations_count'] = $user->formations()->count();
            $stats['published_formations_count'] = $user->formations()->where('statut', 'published')->count();
            $stats['total_students'] = $user->formations()
                ->withCount('inscriptions')
                ->get()
                ->sum('inscriptions_count');
        }

        return $stats;
    }

    /**
     * Données complètes pour la page de profil
     */
    public function getProfilePageData(): JsonResponse
    {
        $user = Auth::user();
        
        return response()->json([
            'profile' => $this->myProfile()->getData(),
            'enrolled_courses' => $this->getEnrolledCourses()->getData(),
            'favorite_videos' => $this->getFavoriteVideos()->getData(),
            'recent_courses' => $this->getRecentCourses()->getData(),
        ]);
    }

    /**
     * Resend email verification
     */
    public function resendEmailVerification(Request $request): JsonResponse
    {
        $user = Auth::user();
        
        if ($user->hasVerifiedEmail()) {
            return response()->json(['message' => 'Email déjà vérifié'], 400);
        }

        $user->sendEmailVerificationNotification();
        
        return response()->json(['message' => 'Email de vérification envoyé']);
    }
}
