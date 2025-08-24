<?php

namespace App\Http\Controllers;

use App\Models\Formation;
use App\Models\FormationObjective;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class FormationObjectiveController extends Controller
{
    public function index(Formation $formation): JsonResponse
    {
        $objectives = $formation->objectives()->orderBy('ordre')->get();
        return response()->json($objectives);
    }

    public function store(Request $request, Formation $formation): JsonResponse
    {
        $this->authorize('update', $formation);

        $validated = $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'nullable|string',
            'ordre' => 'required|integer|min:1',
        ]);

        $validated['formation_id'] = $formation->id;
        $objective = FormationObjective::create($validated);

        return response()->json($objective, 201);
    }

    public function update(Request $request, FormationObjective $objective): JsonResponse
    {
        $this->authorize('update', $objective->formation);

        $validated = $request->validate([
            'titre' => 'sometimes|string|max:255',
            'description' => 'sometimes|string',
            'ordre' => 'sometimes|integer|min:1',
        ]);

        $objective->update($validated);
        return response()->json($objective);
    }

    public function destroy(FormationObjective $objective): JsonResponse
    {
        $this->authorize('update', $objective->formation);
        
        $objective->delete();
        return response()->json(['message' => 'Objectif supprimé avec succès']);
    }
}
