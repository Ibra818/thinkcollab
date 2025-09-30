<?php

namespace App\Http\Controllers;

use App\Models\Collaboration;
use App\Models\Formation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        return response()->json(['data' => $collab], 201);
    }

    public function accept(Collaboration $collaboration)
    {
        abort_unless($collaboration->collaborator_id === Auth::id(), 403);
        $collaboration->update(['status' => 'accepted']);
        return response()->json(['data' => $collaboration]);
    }

    public function decline(Collaboration $collaboration)
    {
        abort_unless($collaboration->collaborator_id === Auth::id(), 403);
        $collaboration->update(['status' => 'declined']);
        return response()->json(['data' => $collaboration]);
    }

    public function revoke(Collaboration $collaboration)
    {
        abort_unless($collaboration->owner_id === Auth::id(), 403);
        $collaboration->delete();
        return response()->json(['message' => 'revoked']);
    }
}


