<?php

namespace App\Http\Controllers;

use App\Models\FeedVideo;
use App\Models\FeedVideoLike;
use App\Models\FeedVideoView;
use App\Models\FeedVideoShare;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\NotificationController;

class FeedVideoController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = FeedVideo::with([
            'user:id,name,avatar_url,role',
            'likes:id,feed_video_id,user_id',
            'views:id,feed_video_id',
            'shares:id,feed_video_id'
        ]);

        // Filtrage par recherche
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('titre', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhereHas('user', function($userQuery) use ($search) {
                      $userQuery->where('name', 'like', "%{$search}%");
                  });
            });
        }

        // Filtrage par formateur
        if ($request->has('formateur_id') && !empty($request->formateur_id)) {
            $query->where('user_id', $request->formateur_id);
        }

        // Tri
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        
        switch ($sortBy) {
            case 'likes':
                $query->withCount('likes')->orderBy('likes_count', $sortOrder);
                break;
            case 'views':
                $query->withCount('views')->orderBy('views_count', $sortOrder);
                break;
            case 'shares':
                $query->withCount('shares')->orderBy('shares_count', $sortOrder);
                break;
            default:
                $query->orderBy($sortBy, $sortOrder);
        }

        $feedVideos = $query->paginate($request->get('per_page', 12));

        // Ajouter les statistiques et vérifier si l'utilisateur connecté a liké
        $userId = Auth::id();
        $feedVideos->getCollection()->transform(function ($video) use ($userId) {
            $video->likes_count = $video->likes->count();
            $video->views_count = $video->views->count();
            $video->shares_count = $video->shares->count();
            // Ensure comments_count present at initialization
            $video->comments_count = \App\Models\FeedVideoComment::where('feed_video_id', $video->id)->count();
            $video->is_liked = $userId ? $video->likes->contains('user_id', $userId) : false;
            
            // Nettoyer les relations pour éviter de surcharger la réponse
            unset($video->likes, $video->views, $video->shares);
            
            return $video;
        });

        return response()->json($feedVideos);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'required|string',
            'url' => 'required|string|max:255',
        ]);

        $validated['user_id'] = Auth::id();
        $feedVideo = FeedVideo::create($validated);

        return response()->json($feedVideo->load('user'), 201);
    }

    public function show(FeedVideo $feedVideo): JsonResponse
    {
        return response()->json($feedVideo->load('user'));
    }

    public function update(Request $request, FeedVideo $feedVideo): JsonResponse
    {
        $this->authorize('update', $feedVideo);

        $validated = $request->validate([
            'titre' => 'sometimes|string|max:255',
            'description' => 'sometimes|string',
            'url' => 'sometimes|string|max:255',
        ]);

        $feedVideo->update($validated);
        return response()->json($feedVideo->load('user'));
    }

    public function destroy(FeedVideo $feedVideo): JsonResponse
    {
        $this->authorize('delete', $feedVideo);
        
        $feedVideo->delete();
        return response()->json(['message' => 'Vidéo feed supprimée avec succès']);
    }

    public function myFeedVideos(): JsonResponse
    {
        $feedVideos = FeedVideo::where('user_id', Auth::id())
                              ->with(['likes', 'views', 'shares'])
                              ->withCount(['likes', 'views', 'shares'])
                              ->orderBy('created_at', 'desc')
                              ->get();
        return response()->json($feedVideos);
    }

    public function like(FeedVideo $feedVideo): JsonResponse
    {
        $userId = Auth::id();
        
        $like = FeedVideoLike::where('user_id', $userId)
                            ->where('feed_video_id', $feedVideo->id)
                            ->first();

        if ($like) {
            $like->delete();
            return response()->json(['message' => 'Like retiré', 'liked' => false]);
        } else {
            FeedVideoLike::create([
                'user_id' => $userId,
                'feed_video_id' => $feedVideo->id,
                'created_at' => now(),
            ]);

            // Notification: like sur vidéo
            if ($feedVideo->user_id !== $userId) {
                NotificationController::createNotification(
                    $feedVideo->user_id,
                    'like',
                    'Nouveau like',
                    Auth::user()->name . ' a aimé votre vidéo',
                    '/feed-videos/' . $feedVideo->id
                );
            }

            return response()->json(['message' => 'Vidéo likée', 'liked' => true]);
        }
    }

    public function recordView(FeedVideo $feedVideo, Request $request): JsonResponse
    {
        FeedVideoView::create([
            'user_id' => Auth::id(),
            'feed_video_id' => $feedVideo->id,
            'ip_address' => $request->ip(),
            'viewed_at' => now(),
        ]);

        return response()->json(['message' => 'Vue enregistrée']);
    }

    public function recordShare(FeedVideo $feedVideo, Request $request): JsonResponse
    {
        $validated = $request->validate([
            'platform' => 'nullable|string|max:50',
        ]);

        FeedVideoShare::create([
            'user_id' => Auth::id(),
            'feed_video_id' => $feedVideo->id,
            'platform' => $validated['platform'] ?? null,
            'ip_address' => $request->ip(),
            'shared_at' => now(),
        ]);

        return response()->json(['message' => 'Partage enregistré']);
    }

    public function getPageData(): JsonResponse
    {
        // Récupérer les catégories pour le filtrage
        $categories = \App\Models\Categorie::select('id', 'nom', 'slug')->get();
        
        // Récupérer les formateurs actifs (qui ont publié des feed videos)
        $formateurs = \App\Models\User::select('id', 'name', 'avatar_url')
                                    ->where('role', 'formateur')
                                    ->whereHas('feedVideos')
                                    ->withCount('feedVideos')
                                    ->get();

        // Statistiques générales
        $stats = [
            'total_videos' => FeedVideo::count(),
            'total_views' => \App\Models\FeedVideoView::count(),
            'total_likes' => \App\Models\FeedVideoLike::count(),
            'total_shares' => \App\Models\FeedVideoShare::count(),
        ];

        return response()->json([
            'categories' => $categories,
            'formateurs' => $formateurs,
            'stats' => $stats,
        ]);
    }
}
