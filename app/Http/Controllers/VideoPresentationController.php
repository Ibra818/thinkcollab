<?php

namespace App\Http\Controllers;

use App\Models\VideoPresentation;
use App\Models\Formation;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class VideoPresentationController extends Controller
{
    public function store(Request $request, Formation $formation): JsonResponse
    {
        $this->authorize('update', $formation);

        $validated = $request->validate([
            'titre' => 'required|string|max:255',
            'url' => 'required|string|max:255',
        ]);

        // Supprimer l'ancienne vidéo de présentation s'il y en a une
        $formation->videoPresentation()?->delete();

        $validated['formation_id'] = $formation->id;
        $videoPresentation = VideoPresentation::create($validated);

        return response()->json($videoPresentation, 201);
    }

    public function show(VideoPresentation $videoPresentation): JsonResponse
    {
        return response()->json($videoPresentation->load('formation'));
    }

    public function update(Request $request, VideoPresentation $videoPresentation): JsonResponse
    {
        $this->authorize('update', $videoPresentation->formation);

        $validated = $request->validate([
            'titre' => 'sometimes|string|max:255',
            'url' => 'sometimes|string|max:255',
        ]);

        $videoPresentation->update($validated);
        return response()->json($videoPresentation);
    }

    public function destroy(VideoPresentation $videoPresentation): JsonResponse
    {
        $this->authorize('update', $videoPresentation->formation);
        
        $videoPresentation->delete();
        return response()->json(['message' => 'Vidéo de présentation supprimée avec succès']);
    }
}
