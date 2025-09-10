<?php

namespace App\Http\Controllers;

use App\Models\{Formation, FeedVideo};
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

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
        try {
            // Validation des données
            $validated = $request->validate([
                'titre' => 'required|string|max:255',
                'description' => 'required|string',
                'prix' => 'required|integer|min:0',
                'categorie' => 'required|exists:categories,id',
                'file' => 'required|file',
                'duree' => 'required|integer|min:0',
                'image_couverture' => 'required|file',
            ]);

            $file = $request->file('file');
            $mimeType = $file->getClientMimeType();
            
            // Utiliser une transaction pour s'assurer de la cohérence des données
            return DB::transaction(function () use ($request, $file, $mimeType) {
                if (!in_array($mimeType, ['image/jpeg', 'image/png', 'image/jpg'])) {
                    // Cas vidéo - créer Formation + FeedVideo
                    $videoPath = $file->store('feedVideos', 'public');
                    $couvPath = $request->file('image_couverture') ->store('formations/couvertures', 'public');

                    // Créer d'abord la Formation
                    $formation = Formation::create([
                        'titre' => $request->titre,
                        'description' => $request->description,
                        'prix' => $request->prix,
                        'categorie_id' => $request->categorie,
                        'image_couverture' => '/'. $couvPath,
                        'statut' => 'brouillon',
                        'formateur_id' => $request->user()->id,
                    ]);

                    // Puis créer le FeedVideo avec l'ID de la formation
                    $feedVideo = FeedVideo::create([
                        'user_id' => $request->user()->id,
                        'description' => $request->description,
                        'categorie_id' => $request->categorie,
                        'miniature' => '/' . $couvPath,
                        'formation_id' => $formation->id,
                        'titre' => $request->titre,
                        'url_video' => '/' . $videoPath,
                        'duree' => $request->duree,
                        'est_public' => true,
                    ]);

                    return response()->json([
                        'message' => 'Formation créée avec succès!',
                        'formation_id' => $formation->id,
                        'feed_video_id' => $feedVideo->id
                    ], 201);

                }
                    // Cas image - créer seulement la Formation
                    


                return response()->json(['message' => 'Type de fichier non supporté'], 400);
            });

        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Erreur de validation',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erreur lors de la création de la formation',
                'error' => $e->getMessage()
            ], 500);
        }
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
                        'url' => $video->url_video,
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
                               ->with([
                                   'categorie:id,nom,slug',
                                   'lessonVideos:id,formation_id,titre,duree,ordre',
                                   'videoPresentation:id,formation_id,url',
                                   'feedvideos:id,formation_id,titre,url_video,duree,est_public'
                               ])
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
