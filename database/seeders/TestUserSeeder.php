<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class TestUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Créer un utilisateur de test
        User::create([
            'name' => 'Utilisateur Test',
            'email' => 'test@example.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);

        // Créer un étudiant
        User::create([
            'name' => 'Marie Étudiant',
            'email' => 'marie@example.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);

        // Créer un formateur
        User::create([
            'name' => 'Jean Formateur',
            'email' => 'jean@example.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);
    }
}
