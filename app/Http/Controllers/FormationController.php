<?php

namespace App\Http\Controllers;

use App\Models\Formation;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class FormationController extends Controller
{
    public function index(): JsonResponse
    {
        $formations = Formation::with(['formateur', 'categorie', 'videoPresentation'])
                               ->published()
                               ->get();
        return response()->json($formations);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'required|string',
            'prix' => 'required|integer|min:0',
            'categorie_id' => 'required|exists:categories,id',
            'statut' => 'sometimes|in:draft,published',
        ]);

        $validated['formateur_id'] = Auth::id();
        $validated['statut'] = $validated['statut'] ?? 'draft';

        $formation = Formation::create($validated);
        return response()->json($formation->load(['formateur', 'categorie']), 201);
    }

    public function show(Formation $formation): JsonResponse
    {
        // Charger toutes les relations nécessaires pour la page de détail
        $formation->load([
            'formateur:id,name,avatar_url,bio,role',
            'categorie:id,nom,slug',
            'objectives' => function($query) {
                $query->orderBy('ordre');
            },
            'sections.lessonVideos' => function($query) {
                $query->orderBy('ordre');
            },
            'videoPresentation',
            'purchases' => function($query) {
                $query->where('statut', 'completed');
            },
            'inscriptions'
        ]);

        // Calculer les statistiques
        $stats = [
            'total_students' => $formation->inscriptions()->count(),
            'total_videos' => $formation->lessonVideos()->count(),
            'total_duration' => $formation->lessonVideos()->sum('duree'),
            'sections_count' => $formation->sections()->count(),
        ];

        // Vérifier si l'utilisateur connecté a accès
        $userAccess = null;
        if (Auth::check()) {
            $userId = Auth::id();
            $userAccess = [
                'has_purchased' => $formation->purchases()->where('user_id', $userId)->where('statut', 'completed')->exists(),
                'is_enrolled' => $formation->inscriptions()->where('user_id', $userId)->exists(),
                'is_owner' => $formation->formateur_id === $userId,
            ];
        }

        // Organiser les sections avec leurs vidéos
        $sectionsWithVideos = $formation->sections->map(function ($section) {
            return [
                'id' => $section->id,
                'titre' => $section->titre,
                'description' => $section->description,
                'ordre' => $section->ordre,
                'videos_count' => $section->lessonVideos->count(),
                'total_duration' => $section->lessonVideos->sum('duree'),
                'videos' => $section->lessonVideos->map(function ($video) {
                    return [
                        'id' => $video->id,
                        'titre' => $video->titre,
                        'duree' => $video->duree,
                        'ordre' => $video->ordre,
                        'url' => $video->url,
                    ];
                })
            ];
        });

        return response()->json([
            'formation' => $formation,
            'stats' => $stats,
            'user_access' => $userAccess,
            'sections_with_videos' => $sectionsWithVideos,
        ]);
    }

    public function update(Request $request, Formation $formation): JsonResponse
    {
        $this->authorize('update', $formation);

        $validated = $request->validate([
            'titre' => 'sometimes|string|max:255',
            'description' => 'sometimes|string',
            'prix' => 'sometimes|integer|min:0',
            'categorie_id' => 'sometimes|exists:categories,id',
            'statut' => 'sometimes|in:draft,published',
        ]);

        $formation->update($validated);
        return response()->json($formation->load(['formateur', 'categorie']));
    }

    public function destroy(Formation $formation): JsonResponse
    {
        $this->authorize('delete', $formation);
        
        $formation->delete();
        return response()->json(['message' => 'Formation supprimée avec succès']);
    }

    public function myFormations(): JsonResponse
    {
        $formations = Formation::where('formateur_id', Auth::id())
                               ->with(['categorie', 'lessonVideos', 'videoPresentation'])
                               ->get();
        return response()->json($formations);
    }

    public function publish(Formation $formation): JsonResponse
    {
        $this->authorize('update', $formation);
        
        $formation->update(['statut' => 'published']);
        return response()->json(['message' => 'Formation publiée avec succès']);
    }

    public function unpublish(Formation $formation): JsonResponse
    {
        $this->authorize('update', $formation);
        
        $formation->update(['statut' => 'draft']);
        return response()->json(['message' => 'Formation dépubliée avec succès']);
    }
}
