<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\GroupMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GroupController extends Controller
{
    public function index()
    {
        $userId = Auth::id();
        $groups = Group::withCount('members')
            ->where('owner_id', $userId)
            ->orWhereHas('members', fn($q) => $q->where('user_id', $userId))
            ->latest()->get();
        return response()->json(['data' => $groups]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255'
        ]);
        $group = Group::create([
            'name' => $validated['name'],
            'owner_id' => Auth::id(),
        ]);
        GroupMember::firstOrCreate([
            'group_id' => $group->id,
            'user_id' => Auth::id(),
        ], ['role' => 'admin']);
        return response()->json(['data' => $group], 201);
    }

    public function addMember(Request $request, Group $group)
    {
        abort_unless($group->owner_id === Auth::id(), 403);
        $data = $request->validate([
            'user_id' => 'required|exists:users,id',
            'role' => 'nullable|in:member,admin'
        ]);
        $member = GroupMember::firstOrCreate([
            'group_id' => $group->id,
            'user_id' => $data['user_id'],
        ], ['role' => $data['role'] ?? 'member']);
        return response()->json(['data' => $member], 201);
    }

    public function removeMember(Group $group, $userId)
    {
        abort_unless($group->owner_id === Auth::id(), 403);
        GroupMember::where('group_id', $group->id)->where('user_id', $userId)->delete();
        return response()->json(['message' => 'removed']);
    }

    public function members(Group $group)
    {
        $members = GroupMember::with('user:id,name,email')->where('group_id', $group->id)->get();
        return response()->json(['data' => $members]);
    }
}


