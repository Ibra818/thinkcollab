<?php

namespace App\Http\Controllers;

use App\Models\Inscription;
use App\Models\Formation;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class InscriptionController extends Controller
{
    public function index(): JsonResponse
    {
        $inscriptions = Inscription::with(['formation.formateur', 'formation.categorie'])
                                  ->where('user_id', Auth::id())
                                  ->get();
        return response()->json($inscriptions);
    }

    public function show(Inscription $inscription): JsonResponse
    {
        $this->authorize('view', $inscription);
        
        return response()->json($inscription->load([
            'formation.lessonVideos',
            'formation.formateur',
            'progressions.lessonVideo'
        ]));
    }

    public function updateStatus(Request $request, Inscription $inscription): JsonResponse
    {
        $this->authorize('update', $inscription);

        $validated = $request->validate([
            'statut' => 'required|in:en_cours,termine',
        ]);

        $inscription->update($validated);
        return response()->json($inscription);
    }

    public function getProgress(Inscription $inscription): JsonResponse
    {
        $this->authorize('view', $inscription);

        $totalVideos = $inscription->formation->lessonVideos()->count();
        $completedVideos = $inscription->progressions()
                                     ->where('pourcentage', 100)
                                     ->count();

        $overallProgress = $totalVideos > 0 ? ($completedVideos / $totalVideos) * 100 : 0;

        return response()->json([
            'inscription' => $inscription,
            'total_videos' => $totalVideos,
            'completed_videos' => $completedVideos,
            'overall_progress' => round($overallProgress, 2),
            'progressions' => $inscription->progressions()->with('lessonVideo')->get()
        ]);
    }
}
