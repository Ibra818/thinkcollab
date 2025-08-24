<?php

namespace App\Http\Controllers;

use App\Models\Progression;
use App\Models\Inscription;
use App\Models\LessonVideo;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class ProgressionController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'inscription_id' => 'required|exists:inscriptions,id',
            'lesson_video_id' => 'required|exists:lesson_videos,id',
            'pourcentage' => 'required|integer|min:0|max:100',
        ]);

        $inscription = Inscription::findOrFail($validated['inscription_id']);
        $this->authorize('view', $inscription);

        $validated['last_seen_at'] = now();

        $progression = Progression::updateOrCreate(
            [
                'inscription_id' => $validated['inscription_id'],
                'lesson_video_id' => $validated['lesson_video_id'],
            ],
            $validated
        );

        return response()->json($progression->load(['inscription', 'lessonVideo']));
    }

    public function show(Progression $progression): JsonResponse
    {
        $this->authorize('view', $progression->inscription);
        
        return response()->json($progression->load(['inscription', 'lessonVideo']));
    }

    public function update(Request $request, Progression $progression): JsonResponse
    {
        $this->authorize('view', $progression->inscription);

        $validated = $request->validate([
            'pourcentage' => 'required|integer|min:0|max:100',
        ]);

        $validated['last_seen_at'] = now();
        $progression->update($validated);

        return response()->json($progression->load(['inscription', 'lessonVideo']));
    }

    public function getByInscription(Inscription $inscription): JsonResponse
    {
        $this->authorize('view', $inscription);

        $progressions = $inscription->progressions()
                                  ->with('lessonVideo')
                                  ->get();

        return response()->json($progressions);
    }
}
