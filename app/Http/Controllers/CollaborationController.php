<?php

namespace App\Http\Controllers;

use App\Models\Collaboration;
use App\Models\Formation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\NotificationController;

class CollaborationController extends Controller
{
    public function index()
    {
        $userId = Auth::id();
        $collabs = Collaboration::with(['formation:id,titre','owner:id,name','collaborator:id,name'])
            ->where(function($q) use($userId){
                $q->where('owner_id',$userId)->orWhere('collaborator_id',$userId);
            })
            ->latest()->get();
        return response()->json(['data' => $collabs]);
    }

    public function invite(Request $request, Formation $formation)
    {
        $this->authorize('update', $formation);
        $validated = $request->validate([
            'collaborator_id' => 'required|exists:users,id'
        ]);
        $collab = Collaboration::firstOrCreate([
            'formation_id' => $formation->id,
            'owner_id' => Auth::id(),
            'collaborator_id' => $validated['collaborator_id'],
        ], [ 'status' => 'pending' ]);

        // Notification: invitation à collaborer
        if ($collab->wasRecentlyCreated) {
            NotificationController::createNotification(
                $validated['collaborator_id'],
                'collaboration',
                'Invitation à collaborer',
                Auth::user()->name . ' vous invite à collaborer sur le projet ' . $formation->titre,
                '/collaborations'
            );
        }

        return response()->json(['data' => $collab], 201);
    }

    public function accept(Collaboration $collaboration)
    {
        abort_unless($collaboration->collaborator_id === Auth::id(), 403);
        $collaboration->update(['status' => 'accepted']);

        // Notification: collaboration acceptée
        NotificationController::createNotification(
            $collaboration->owner_id,
            'collaboration',
            'Collaboration acceptée',
            Auth::user()->name . ' a accepté votre invitation à collaborer',
            '/formations/' . $collaboration->formation_id
        );

        return response()->json(['data' => $collaboration]);
    }

    public function decline(Collaboration $collaboration)
    {
        abort_unless($collaboration->collaborator_id === Auth::id(), 403);
        $collaboration->update(['status' => 'declined']);

        // Notification: collaboration refusée
        NotificationController::createNotification(
            $collaboration->owner_id,
            'collaboration',
            'Collaboration refusée',
            Auth::user()->name . ' a refusé votre invitation à collaborer',
            '/collaborations'
        );

        return response()->json(['data' => $collaboration]);
    }

    public function revoke(Collaboration $collaboration)
    {
        abort_unless($collaboration->owner_id === Auth::id(), 403);
        $collaboration->delete();
        return response()->json(['message' => 'revoked']);
    }
}



