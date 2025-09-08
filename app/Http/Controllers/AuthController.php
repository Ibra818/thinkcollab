<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    // public function showLogin()
    // {
    //     return view('auth.login');
    // }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/profile-selection');
        }

        return back()->withErrors([
            'email' => 'Les identifiants fournis ne correspondent pas.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }

    // API Methods

    /**
     * API Registration
     */
    public function register(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'password_confirmation' => 'required|string|same:password',
            'role' => 'nullable|in:apprenant,formateur,admin,superadmin',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        if($request -> password == $request -> password_confirmation){
             $user = User::create([
                'name' => $request-> name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => $request->profile ?? null, // Permet de créer un utilisateur sans rôle
            ]);

            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'success' => true,
                'message' => 'Compte créé avec succès. Veuillez définir votre profil.',
                'user' => $user,
                'token' => $token,
            ], 200);
        }else{
            return response() -> json([ 'status' => '404', 'message' => 'not found']);
        }

       
    }

    /**
     * API Registration without role (for admin use)
     */
    public function createUser(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'role' => 'nullable|in:apprenant,formateur,admin,superadmin',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role ?? null,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Utilisateur créé avec succès',
            'user' => $user,
        ], 201);
    }

    /**
     * Update user role
     */
    public function updateUserRole(Request $request, $userId): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'role' => 'required|in:apprenant,formateur,admin,superadmin',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $user = User::find($userId);
        
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Utilisateur non trouvé'
            ], 404);
        }

        $user->update(['role' => $request->role]);

        return response()->json([
            'success' => true,
            'message' => 'Rôle mis à jour avec succès',
            'user' => $user->fresh(),
        ]);
    }

    /**
     * Get all users (for admin use)
     */
    public function getAllUsers(): JsonResponse
    {
        $users = User::select('id', 'name', 'email', 'role', 'created_at')
                     ->orderBy('created_at', 'desc')
                     ->get();

        return response()->json([
            'success' => true,
            'users' => $users,
        ]);
    }

    /**
     * Get user by ID
     */
    public function getUserById($userId): JsonResponse
    {
        $user = User::select('id', 'name', 'email', 'role', 'bio', 'avatar_url', 'created_at')
                    ->find($userId);

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Utilisateur non trouvé'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'user' => $user,
        ]);
    }

    /**
     * API Login
     */
    public function apiLogin(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid credentials'
            ], 401);
        }

        $user = Auth::user();
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Login successful',
            'user' => $user,
            'token' => $token,
        ]);
    }

    /**
     * API Logout
     */
    public function apiLogout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'success' => true,
            'message' => 'Logged out successfully'
        ]);
    }

    /**
     * Change user role from 'apprenant' to 'formateur'
     */
    public function changeToFormateur(Request $request): JsonResponse
    {
        $user = Auth::user();

        // Check if user is currently an 'apprenant'
        if ($user->role !== 'apprenant') {
            return response()->json([
                'success' => false,
                'message' => 'Only students can become instructors',
            ], 400);
        }

        // // Validate additional information if needed
        // $validator = Validator::make($request->all(), [
        //     'bio' => 'nullable|string|max:1000',
        //     'motivation' => 'nullable|string|max:500',
        // ]);

        // if ($validator->fails()) {
        //     return response()->json([
        //         'success' => false,
        //         'message' => 'Validation failed',
        //         'errors' => $validator->errors()
        //     ], 422);
        // }

        // Update user role and bio if provided
        $user->update([
            'role' => 'formateur',
            // 'bio' => $request->bio ?? $user->bio,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Successfully upgraded to instructor',
            'user' => $user->fresh(),
        ]);
    }

    /**
     * Delete user account with password confirmation and reason
     */
    public function deleteAccount(Request $request): JsonResponse
    {
        $user = Auth::user();

        // Validate request
        $validator = Validator::make($request->all(), [
            'password' => 'required|string',
            'deletion_reason' => 'required|string|max:500',
            'confirmation' => 'required|boolean|accepted',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        // Verify password
        if (!Hash::check($request->password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid password',
            ], 401);
        }

        // Log deletion reason (you might want to store this in a separate table)
        \Log::info('Account deletion', [
            'user_id' => $user->id,
            'user_email' => $user->email,
            'reason' => $request->deletion_reason,
            'deleted_at' => now(),
        ]);

        // Revoke all tokens
        $user->tokens()->delete();

        // Delete the user account
        $userName = $user->name;
        $user->delete();

        return response()->json([
            'success' => true,
            'message' => "Account for {$userName} has been successfully deleted",
        ]);
    }
}
