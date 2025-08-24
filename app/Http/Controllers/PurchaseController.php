<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use App\Models\Formation;
use App\Models\Inscription;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PurchaseController extends Controller
{
    public function index(): JsonResponse
    {
        $purchases = Purchase::with(['formation', 'user'])
                            ->where('user_id', Auth::id())
                            ->get();
        return response()->json($purchases);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'formation_id' => 'required|exists:formations,id',
            'payment_provider_id' => 'sometimes|string',
        ]);

        $formation = Formation::findOrFail($validated['formation_id']);
        
        // Vérifier si l'utilisateur n'a pas déjà acheté cette formation
        $existingPurchase = Purchase::where('user_id', Auth::id())
                                   ->where('formation_id', $formation->id)
                                   ->where('status', 'paid')
                                   ->first();

        if ($existingPurchase) {
            return response()->json(['message' => 'Formation déjà achetée'], 400);
        }

        $purchase = Purchase::create([
            'user_id' => Auth::id(),
            'formation_id' => $formation->id,
            'amount' => $formation->prix,
            'status' => 'pending',
            'payment_provider_id' => $validated['payment_provider_id'] ?? null,
        ]);

        return response()->json($purchase->load('formation'), 201);
    }

    public function show(Purchase $purchase): JsonResponse
    {
        $this->authorize('view', $purchase);
        return response()->json($purchase->load(['formation', 'user']));
    }

    public function updateStatus(Request $request, Purchase $purchase): JsonResponse
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,paid,failed',
            'payment_provider_id' => 'sometimes|string',
        ]);

        DB::transaction(function () use ($purchase, $validated) {
            $purchase->update($validated);

            // Si le paiement est confirmé, créer une inscription
            if ($validated['status'] === 'paid') {
                Inscription::firstOrCreate([
                    'user_id' => $purchase->user_id,
                    'formation_id' => $purchase->formation_id,
                ], [
                    'date_inscription' => now(),
                    'statut' => 'en_cours',
                ]);
            }
        });

        return response()->json($purchase->load('formation'));
    }

    public function webhook(Request $request): JsonResponse
    {
        // Logique pour traiter les webhooks de paiement (Stripe, etc.)
        $validated = $request->validate([
            'payment_provider_id' => 'required|string',
            'status' => 'required|in:paid,failed',
        ]);

        $purchase = Purchase::where('payment_provider_id', $validated['payment_provider_id'])->first();

        if (!$purchase) {
            return response()->json(['message' => 'Purchase not found'], 404);
        }

        DB::transaction(function () use ($purchase, $validated) {
            $purchase->update(['status' => $validated['status']]);

            if ($validated['status'] === 'paid') {
                Inscription::firstOrCreate([
                    'user_id' => $purchase->user_id,
                    'formation_id' => $purchase->formation_id,
                ], [
                    'date_inscription' => now(),
                    'statut' => 'en_cours',
                ]);
            }
        });

        return response()->json(['message' => 'Webhook processed successfully']);
    }
}
