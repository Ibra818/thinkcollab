<?php

namespace Database\Seeders;

use App\Models\LessonVideo;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LessonVideoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Vidéos pour Laravel Formation (ID: 1)
        $laravelVideos = [
            [
                'titre' => 'Installation et Configuration de Laravel',
                'description' => 'Apprenez à installer Laravel et configurer votre environnement de développement',
                'url_video' => '/videos/laravel/01-installation-configuration.mp4',
                'duree' => 900, // 15 minutes
                'ordre' => 1,
                'formation_id' => 1,
                'section_id' => 1,
                'est_gratuit' => true,
            ],
            [
                'titre' => 'Structure des Dossiers Laravel',
                'description' => 'Découvrez l\'organisation des fichiers et dossiers dans un projet Laravel',
                'url_video' => '/videos/laravel/02-structure-dossiers.mp4',
                'duree' => 720, // 12 minutes
                'ordre' => 2,
                'formation_id' => 1,
                'section_id' => 1,
                'est_gratuit' => true,
            ],
            [
                'titre' => 'Artisan CLI - Votre Meilleur Ami',
                'description' => 'Maîtrisez les commandes Artisan pour être plus productif',
                'url_video' => '/videos/laravel/03-artisan-cli.mp4',
                'duree' => 1080, // 18 minutes
                'ordre' => 3,
                'formation_id' => 1,
                'section_id' => 1,
                'est_gratuit' => false,
            ],
            [
                'titre' => 'Routes et Méthodes HTTP',
                'description' => 'Comprendre le système de routage de Laravel',
                'url_video' => '/videos/laravel/04-routes-http.mp4',
                'duree' => 1200, // 20 minutes
                'ordre' => 4,
                'formation_id' => 1,
                'section_id' => 2,
                'est_gratuit' => false,
            ],
            [
                'titre' => 'Controllers et Actions',
                'description' => 'Créer et organiser vos contrôleurs Laravel',
                'url_video' => '/videos/laravel/05-controllers-actions.mp4',
                'duree' => 1500, // 25 minutes
                'ordre' => 5,
                'formation_id' => 1,
                'section_id' => 2,
                'est_gratuit' => false,
            ],
            [
                'titre' => 'Middleware et Sécurité',
                'description' => 'Sécuriser vos routes avec les middlewares',
                'url_video' => '/videos/laravel/06-middleware-securite.mp4',
                'duree' => 1800, // 30 minutes
                'ordre' => 6,
                'formation_id' => 1,
                'section_id' => 2,
                'est_gratuit' => false,
            ],
            [
                'titre' => 'Migrations et Schema Builder',
                'description' => 'Gérer votre base de données avec les migrations',
                'url_video' => '/videos/laravel/07-migrations-schema.mp4',
                'duree' => 1680, // 28 minutes
                'ordre' => 7,
                'formation_id' => 1,
                'section_id' => 3,
                'est_gratuit' => false,
            ],
            [
                'titre' => 'Eloquent Models et Relations',
                'description' => 'Maîtriser l\'ORM Eloquent et les relations',
                'url_video' => '/videos/laravel/08-eloquent-relations.mp4',
                'duree' => 2100, // 35 minutes
                'ordre' => 8,
                'formation_id' => 1,
                'section_id' => 3,
                'est_gratuit' => false,
            ],
        ];

        // Vidéos pour React Formation (ID: 2)
        $reactVideos = [
            [
                'titre' => 'Introduction à React.js',
                'description' => 'Découvrez React et ses concepts fondamentaux',
                'url_video' => '/videos/react/01-introduction-react.mp4',
                'duree' => 840, // 14 minutes
                'ordre' => 1,
                'formation_id' => 2,
                'section_id' => null,
                'est_gratuit' => true,
            ],
            [
                'titre' => 'JSX et Components',
                'description' => 'Comprendre JSX et créer vos premiers composants',
                'url_video' => '/videos/react/02-jsx-components.mp4',
                'duree' => 1260, // 21 minutes
                'ordre' => 2,
                'formation_id' => 2,
                'section_id' => null,
                'est_gratuit' => true,
            ],
            [
                'titre' => 'State et Props',
                'description' => 'Gérer l\'état et les propriétés des composants',
                'url_video' => '/videos/react/03-state-props.mp4',
                'duree' => 1800, // 30 minutes
                'ordre' => 3,
                'formation_id' => 2,
                'section_id' => null,
                'est_gratuit' => false,
            ],
            [
                'titre' => 'React Hooks - useState et useEffect',
                'description' => 'Maîtriser les hooks les plus importants',
                'url_video' => '/videos/react/04-hooks-basics.mp4',
                'duree' => 2400, // 40 minutes
                'ordre' => 4,
                'formation_id' => 2,
                'section_id' => null,
                'est_gratuit' => false,
            ],
        ];

        // Vidéos pour UX/UI Design Formation (ID: 3)
        $designVideos = [
            [
                'titre' => 'Principes Fondamentaux du Design',
                'description' => 'Les bases du design : couleurs, typographie, espacement',
                'url_video' => '/videos/design/01-principes-fondamentaux.mp4',
                'duree' => 1500, // 25 minutes
                'ordre' => 1,
                'formation_id' => 3,
                'section_id' => null,
                'est_gratuit' => true,
            ],
            [
                'titre' => 'Recherche Utilisateur et Personas',
                'description' => 'Comprendre vos utilisateurs pour mieux designer',
                'url_video' => '/videos/design/02-recherche-utilisateur.mp4',
                'duree' => 1800, // 30 minutes
                'ordre' => 2,
                'formation_id' => 3,
                'section_id' => null,
                'est_gratuit' => false,
            ],
            [
                'titre' => 'Wireframing et Prototypage',
                'description' => 'Créer des wireframes et prototypes efficaces',
                'url_video' => '/videos/design/03-wireframing-prototypage.mp4',
                'duree' => 2100, // 35 minutes
                'ordre' => 3,
                'formation_id' => 3,
                'section_id' => null,
                'est_gratuit' => false,
            ],
        ];

        // Insérer toutes les vidéos
        foreach ($laravelVideos as $video) {
            LessonVideo::create($video);
        }

        foreach ($reactVideos as $video) {
            LessonVideo::create($video);
        }

        foreach ($designVideos as $video) {
            LessonVideo::create($video);
        }
    }
}
