<?php

namespace Database\Seeders;

use App\Models\Formation;
use App\Models\FormationObjective;
use App\Models\FormationSection;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FormationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Formation Laravel
        $laravelFormation = Formation::create([
            'titre' => 'Laravel Avancé - De Zéro à Expert',
            'description' => 'Maîtrisez Laravel de A à Z avec cette formation complète. Apprenez les concepts avancés, les bonnes pratiques et développez des applications web robustes.',
            'prix' => 25000, // 25,000 FCFA
            'duree_estimee' => 2400, // 40 heures en minutes
            'niveau' => 'intermediaire',
            'langue' => 'fr',
            'statut' => 'publie',
            'formateur_id' => 2, // Amadou Diallo
            'categorie_id' => 1, // Développement Web
            'image_couverture' => '/images/formations/laravel-avance.jpg',
            'video_preview' => '/videos/previews/laravel-intro.mp4',
            'certificat_disponible' => true,
        ]);

        // Objectifs Laravel
        FormationObjective::create([
            'formation_id' => $laravelFormation->id,
            'titre' => 'Maîtriser l\'architecture MVC',
            'description' => 'Comprendre et implémenter le pattern MVC avec Laravel',
            'ordre' => 1,
        ]);

        FormationObjective::create([
            'formation_id' => $laravelFormation->id,
            'titre' => 'Développer des APIs REST',
            'description' => 'Créer des APIs robustes et sécurisées avec Laravel',
            'ordre' => 2,
        ]);

        FormationObjective::create([
            'formation_id' => $laravelFormation->id,
            'titre' => 'Gérer l\'authentification',
            'description' => 'Implémenter l\'authentification et l\'autorisation',
            'ordre' => 3,
        ]);

        // Sections Laravel
        $section1 = FormationSection::create([
            'formation_id' => $laravelFormation->id,
            'titre' => 'Introduction à Laravel',
            'description' => 'Les bases de Laravel et configuration de l\'environnement',
            'ordre' => 1,
        ]);

        $section2 = FormationSection::create([
            'formation_id' => $laravelFormation->id,
            'titre' => 'Routing et Controllers',
            'description' => 'Gestion des routes et des contrôleurs',
            'ordre' => 2,
        ]);

        $section3 = FormationSection::create([
            'formation_id' => $laravelFormation->id,
            'titre' => 'Eloquent ORM',
            'description' => 'Base de données et relations avec Eloquent',
            'ordre' => 3,
        ]);

        // Formation React
        $reactFormation = Formation::create([
            'titre' => 'React.js - Développement Frontend Moderne',
            'description' => 'Apprenez React.js et créez des interfaces utilisateur interactives et performantes. Hooks, Context API, et bonnes pratiques incluses.',
            'prix' => 20000, // 20,000 FCFA
            'duree_estimee' => 1800, // 30 heures
            'niveau' => 'debutant',
            'langue' => 'fr',
            'statut' => 'publie',
            'formateur_id' => 2, // Amadou Diallo
            'categorie_id' => 1, // Développement Web
            'image_couverture' => '/images/formations/react-moderne.jpg',
            'video_preview' => '/videos/previews/react-intro.mp4',
            'certificat_disponible' => true,
        ]);

        // Formation UX/UI Design
        $designFormation = Formation::create([
            'titre' => 'UX/UI Design - Créer des Expériences Exceptionnelles',
            'description' => 'Maîtrisez les principes du design UX/UI. De la recherche utilisateur au prototypage, créez des interfaces qui convertissent.',
            'prix' => 18000, // 18,000 FCFA
            'duree_estimee' => 2100, // 35 heures
            'niveau' => 'debutant',
            'langue' => 'fr',
            'statut' => 'publie',
            'formateur_id' => 3, // Fatou Sall
            'categorie_id' => 3, // Design
            'image_couverture' => '/images/formations/ux-ui-design.jpg',
            'video_preview' => '/videos/previews/design-intro.mp4',
            'certificat_disponible' => true,
        ]);

        // Formation Cybersécurité
        $cyberFormation = Formation::create([
            'titre' => 'Cybersécurité - Ethical Hacking et Sécurité Web',
            'description' => 'Apprenez à sécuriser vos applications et infrastructures. Tests de pénétration, OWASP Top 10, et bonnes pratiques de sécurité.',
            'prix' => 30000, // 30,000 FCFA
            'duree_estimee' => 3000, // 50 heures
            'niveau' => 'avance',
            'langue' => 'fr',
            'statut' => 'publie',
            'formateur_id' => 4, // Ousmane Ba
            'categorie_id' => 5, // Cybersécurité
            'image_couverture' => '/images/formations/cybersecurite.jpg',
            'video_preview' => '/videos/previews/cyber-intro.mp4',
            'certificat_disponible' => true,
        ]);

        // Formation Flutter
        $flutterFormation = Formation::create([
            'titre' => 'Flutter - Développement Mobile Cross-Platform',
            'description' => 'Développez des applications mobiles natives pour iOS et Android avec Flutter. Dart, widgets, et déploiement inclus.',
            'prix' => 22000, // 22,000 FCFA
            'duree_estimee' => 2700, // 45 heures
            'niveau' => 'intermediaire',
            'langue' => 'fr',
            'statut' => 'publie',
            'formateur_id' => 4, // Ousmane Ba
            'categorie_id' => 2, // Mobile
            'image_couverture' => '/images/formations/flutter-mobile.jpg',
            'video_preview' => '/videos/previews/flutter-intro.mp4',
            'certificat_disponible' => true,
        ]);

        // Formation en brouillon
        Formation::create([
            'titre' => 'Python Data Science - Analyse de Données',
            'description' => 'Formation en cours de développement sur l\'analyse de données avec Python, Pandas, et Matplotlib.',
            'prix' => 28000,
            'duree_estimee' => 3600, // 60 heures
            'niveau' => 'intermediaire',
            'langue' => 'fr',
            'statut' => 'brouillon',
            'formateur_id' => 2, // Amadou Diallo
            'categorie_id' => 4, // Data Science
            'image_couverture' => '/images/formations/python-data.jpg',
            'certificat_disponible' => false,
        ]);
    }
}
