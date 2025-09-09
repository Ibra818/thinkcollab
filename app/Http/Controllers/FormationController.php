<?php

namespace App\Http\Controllers;

use App\Models\{Formation, FeedVideo};
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
        // return response() -> json($request);
        // $validated = $request->validate([
        //     'titre' => 'required|string|max:255',
        //     'description' => 'required|string',
        //     'prix' => 'required|integer|min:0',
        //     'categorie_id' => 'required|exists:categories,id',
        //     'statut' => 'required|in:brouillon,publie',
        // ]);

        $file = $request->file('file');
        $mimeType = $file->getClientMimeType();
        
        if(!in_array($mimeType, ['image/jpeg', 'image/png', 'image/jpg'])){
            $videoPath = $file->store('feedVideos', 'public');

            FeedVideo::create([
                'user_id' => $request -> user() ->id,
                'description' => $request -> description,
                'categorie_id' => $request -> categorie,
                'miniature' => 'Image not found',
                'formation_id' => $request -> id,
                'titre' => $request -> titre,
                'url_video' => '/'.$videoPath,
                'duree' => $request -> duree,
            ]);

            $formation = Formation::create([
                'titre' => $request -> titre,
                'description' => $request -> description,
                'prix' => $request -> prix,
                'categorie_id' => $request -> categorie,
                'image_couverture' => 'Image not found',
                'statut' => 'brouillon',
                'formateur_id' => $request -> user() ->id,
            ]);

            return response() -> json(['message' => 'Formation créer avec success!', 'formation_id' => $formation->id, 201]);
        }elseif(in_array($mimeType, ['image/jpeg', 'image/png', 'image/jpg'])){

            $couvPath = $file->store('formations/couvertures', 'public');
            
            $formation = Formation::create([
                'titre' => $request -> titre,
                'description' => $request -> description,
                'prix' => $request -> prix,
                'categorie_id' => $request -> categorie,
                'image_couverture' => '/'.$couvPath,
                'statut' => 'brouillon',
                'formateur_id' => $request -> user() ->id,
            ]);

            return response() -> json(['message' => 'Formation créer avec success!', 'formation_id' => $formation->id, 201]);
        }
        // $vid_intro = $request -> file('video_intro') -> store('feedVideos', 'public');
        // $FeedVideo= FeedVideo::create([
        //     'user_id' => $request -> user() ->id,
        //     'description' => $request -> description,
        //     'categorie_id' => $request -> categorie_id,
        //     // 'formation_id' => $formation -> id,
        //     'miniature' => '/'.$couvPath,
        //     'titre' => $request -> titre,
        //     'url_video' => '/'.$vid_intro,
        //     'duree' => $request -> duree,
        // ]);
        return response() -> json(['message' => 'Erreur', 402]);
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
