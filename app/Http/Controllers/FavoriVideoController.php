<?php

namespace App\Http\Controllers;

use App\Models\FavoriVideo;
use App\Models\LessonVideo;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class FavoriVideoController extends Controller
{
    public function index(): JsonResponse
    {
        $favoris = FavoriVideo::with(['lessonVideo.formation'])
                             ->where('user_id', Auth::id())
                             ->orderBy('created_at', 'desc')
                             ->get();
        return response()->json($favoris);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'lesson_video_id' => 'required|exists:lesson_videos,id',
        ]);

        $lessonVideo = LessonVideo::findOrFail($validated['lesson_video_id']);
        $this->authorize('view', $lessonVideo);

        $favori = FavoriVideo::firstOrCreate([
            'user_id' => Auth::id(),
            'lesson_video_id' => $validated['lesson_video_id'],
        ]);

        return response()->json($favori->load(['lessonVideo.formation']), 201);
    }

    public function destroy(FavoriVideo $favoriVideo): JsonResponse
    {
        $this->authorize('delete', $favoriVideo);
        
        $favoriVideo->delete();
        return response()->json(['message' => 'Favori supprimé avec succès']);
    }

    public function toggle(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'lesson_video_id' => 'required|exists:lesson_videos,id',
        ]);

        $lessonVideo = LessonVideo::findOrFail($validated['lesson_video_id']);
        $this->authorize('view', $lessonVideo);

        $favori = FavoriVideo::where('user_id', Auth::id())
                            ->where('lesson_video_id', $validated['lesson_video_id'])
                            ->first();

        if ($favori) {
            $favori->delete();
            return response()->json(['message' => 'Favori supprimé', 'favorited' => false]);
        } else {
            $favori = FavoriVideo::create([
                'user_id' => Auth::id(),
                'lesson_video_id' => $validated['lesson_video_id'],
            ]);
            return response()->json(['message' => 'Ajouté aux favoris', 'favorited' => true, 'favori' => $favori]);
        }
    }
}
