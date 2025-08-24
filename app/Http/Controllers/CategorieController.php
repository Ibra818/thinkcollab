<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;

class CategorieController extends Controller
{
    public function index(): JsonResponse
    {
        $categories = Categorie::all();
        return response()->json($categories);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
        ]);

        $validated['slug'] = Str::slug($validated['nom']);

        $categorie = Categorie::create($validated);
        return response()->json($categorie, 201);
    }

    public function show(Categorie $categorie): JsonResponse
    {
        return response()->json($categorie->load('formations'));
    }

    public function update(Request $request, Categorie $categorie): JsonResponse
    {
        $validated = $request->validate([
            'nom' => 'sometimes|string|max:255',
        ]);

        if (isset($validated['nom'])) {
            $validated['slug'] = Str::slug($validated['nom']);
        }

        $categorie->update($validated);
        return response()->json($categorie);
    }

    public function destroy(Categorie $categorie): JsonResponse
    {
        $categorie->delete();
        return response()->json(['message' => 'Catégorie supprimée avec succès']);
    }
}
