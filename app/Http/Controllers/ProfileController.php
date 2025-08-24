<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function show()
    {
        return view('profile.selection');
    }

    public function store(Request $request)
    {
        $request->validate([
            'profile_type' => 'required|in:formateur,apprenant',
        ]);

        $user = Auth::user();
        
        // Ici vous pouvez ajouter la logique pour sauvegarder le type de profil
        // par exemple dans une table user_profiles ou directement dans la table users
        
        if ($request->profile_type === 'apprenant') {
            return redirect()->route('student.dashboard');
        } else {
            // Rediriger vers le dashboard formateur quand il sera créé
            return redirect()->route('student.dashboard'); // temporaire
        }
    }
}
