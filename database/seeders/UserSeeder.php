<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin user
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@bintschool.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'bio' => 'Administrateur de la plateforme Bint School',
            'avatar_url' => '/images/avatars/admin.jpg',
            'email_verified_at' => now(),
        ]);

        // Formateurs
        User::create([
            'name' => 'Amadou Diallo',
            'email' => 'amadou@bintschool.com',
            'password' => Hash::make('password'),
            'role' => 'formateur',
            'bio' => 'Développeur Full Stack avec 8 ans d\'expérience. Spécialisé en Laravel, Vue.js et React.',
            'avatar_url' => '/images/avatars/amadou.jpg',
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'Fatou Sall',
            'email' => 'fatou@bintschool.com',
            'password' => Hash::make('password'),
            'role' => 'formateur',
            'bio' => 'Designer UX/UI et développeuse frontend. Passionnée par l\'expérience utilisateur.',
            'avatar_url' => '/images/avatars/fatou.jpg',
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'Ousmane Ba',
            'email' => 'ousmane@bintschool.com',
            'password' => Hash::make('password'),
            'role' => 'formateur',
            'bio' => 'Expert en cybersécurité et développement mobile. Formateur certifié.',
            'avatar_url' => '/images/avatars/ousmane.jpg',
            'email_verified_at' => now(),
        ]);

        // Apprenants
        User::create([
            'name' => 'Aissatou Ndiaye',
            'email' => 'aissatou@example.com',
            'password' => Hash::make('password'),
            'role' => 'apprenant',
            'bio' => 'Étudiante en informatique, passionnée par le développement web.',
            'avatar_url' => '/images/avatars/aissatou.jpg',
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'Mamadou Sy',
            'email' => 'mamadou@example.com',
            'password' => Hash::make('password'),
            'role' => 'apprenant',
            'bio' => 'Entrepreneur en reconversion dans le numérique.',
            'avatar_url' => '/images/avatars/mamadou.jpg',
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'Khady Faye',
            'email' => 'khady@example.com',
            'password' => Hash::make('password'),
            'role' => 'apprenant',
            'bio' => 'Développeuse junior, toujours en apprentissage.',
            'avatar_url' => '/images/avatars/khady.jpg',
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'Ibrahima Diop',
            'email' => 'ibrahima@example.com',
            'password' => Hash::make('password'),
            'role' => 'apprenant',
            'bio' => 'Passionné de technologie et d\'innovation.',
            'avatar_url' => '/images/avatars/ibrahima.jpg',
            'email_verified_at' => now(),
        ]);

        // Utilisateur de test pour les API
        User::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => Hash::make('password'),
            'role' => 'apprenant',
            'bio' => 'Utilisateur de test pour les APIs',
            'avatar_url' => '/images/avatars/test.jpg',
            'email_verified_at' => now(),
        ]);
    }
}
