<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StudentController;

Route::get('/', function () {
    return redirect()->route('login');
});

// Routes d'authentification
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Route de sélection de profil
Route::get('/profile-selection', [ProfileController::class, 'show'])->name('profile.selection');
Route::post('/profile-selection', [ProfileController::class, 'store'])->name('profile.store');

// Dashboard étudiant

    Route::get('/student/dashboard', [StudentController::class, 'dashboard'])->name('student.dashboard');
