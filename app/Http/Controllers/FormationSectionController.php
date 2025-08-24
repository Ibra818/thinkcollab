<?php

namespace App\Http\Controllers;

use App\Models\Formation;
use App\Models\FormationSection;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class FormationSectionController extends Controller
{
    public function index(Formation $formation): JsonResponse
    {
        $sections = $formation->sections()
                             ->with(['lessonVideos' => function($query) {
                                 $query->orderBy('ordre');
                             }])
                             ->orderBy('ordre')
                             ->get();

        // Ajouter les statistiques pour chaque section
        $sectionsWithStats = $sections->map(function ($section) {
            return [
                'id' => $section->id,
                'titre' => $section->titre,
                'description' => $section->description,
                'ordre' => $section->ordre,
                'videos_count' => $section->lessonVideos->count(),
                'total_duration' => $section->lessonVideos->sum('duree'),
                'videos' => $section->lessonVideos,
                'created_at' => $section->created_at,
                'updated_at' => $section->updated_at,
            ];
        });

        return response()->json($sectionsWithStats);
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
        $section = FormationSection::create($validated);

        return response()->json($section, 201);
    }

    public function update(Request $request, FormationSection $section): JsonResponse
    {
        $this->authorize('update', $section->formation);

        $validated = $request->validate([
            'titre' => 'sometimes|string|max:255',
            'description' => 'sometimes|string',
            'ordre' => 'sometimes|integer|min:1',
        ]);

        $section->update($validated);
        return response()->json($section);
    }

    public function destroy(FormationSection $section): JsonResponse
    {
        $this->authorize('update', $section->formation);
        
        $section->delete();
        return response()->json(['message' => 'Section supprimée avec succès']);
    }

    public function reorder(Request $request, Formation $formation): JsonResponse
    {
        $this->authorize('update', $formation);

        $validated = $request->validate([
            'sections' => 'required|array',
            'sections.*.id' => 'required|exists:formation_sections,id',
            'sections.*.ordre' => 'required|integer|min:1',
        ]);

        foreach ($validated['sections'] as $sectionData) {
            FormationSection::where('id', $sectionData['id'])
                           ->where('formation_id', $formation->id)
                           ->update(['ordre' => $sectionData['ordre']]);
        }

        return response()->json(['message' => 'Ordre des sections mis à jour avec succès']);
    }
}
