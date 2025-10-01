<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\GroupMember;
use App\Models\GroupMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class GroupMessageController extends Controller
{
    public function index(Group $group)
    {
        $this->authorizeMember($group->id);
        $messages = GroupMessage::where('group_id', $group->id)
            ->with('sender:id,name')
            ->latest()->limit(200)->get()->reverse()->values();
        return response()->json(['data' => $messages]);
    }

    public function store(Request $request, Group $group)
    {
        $this->authorizeMember($group->id);
        $data = $request->validate([
            'content' => 'nullable|string',
            'file' => 'nullable|file|max:10240'
        ]);
        $payload = [
            'group_id' => $group->id,
            'sender_id' => Auth::id(),
            'content' => $data['content'] ?? null,
        ];
        if ($request->hasFile('file')) {
            $path = $request->file('file')->store('group_messages', 'public');
            $payload['file_path'] = $path;
            $payload['file_name'] = $request->file('file')->getClientOriginalName();
            $payload['file_mime'] = $request->file('file')->getClientMimeType();
        }
        $message = GroupMessage::create($payload);
        return response()->json(['data' => $message->load('sender:id,name')], 201);
    }

    private function authorizeMember(int $groupId): void
    {
        $isMember = GroupMember::where('group_id', $groupId)
            ->where('user_id', Auth::id())
            ->exists();
        abort_unless($isMember, 403);
    }
}



