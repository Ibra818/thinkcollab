<?php

namespace Database\Seeders;

use App\Models\FeedVideo;
use App\Models\FeedVideoLike;
use App\Models\FeedVideoView;
use App\Models\FeedVideoShare;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FeedVideoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Vidéos du feed par différents formateurs
        $feedVideos = [
            [
                'titre' => '5 Astuces Laravel que Vous Devez Connaître',
                'description' => 'Découvrez 5 astuces Laravel qui vont améliorer votre productivité et la qualité de votre code.',
                'url_video' => '/videos/feed/laravel-astuces-5.mp4',
                'miniature' => '/images/feed/laravel-astuces-5.jpg',
                'duree' => 480, // 8 minutes
                'user_id' => 2, // Amadou Diallo
                'categorie_id' => 1, // Développement Web
                'est_public' => true,
            ],
            [
                'titre' => 'Design System : Créer une Cohérence Visuelle',
                'description' => 'Apprenez à créer un design system efficace pour maintenir la cohérence dans vos projets.',
                'url_video' => '/videos/feed/design-system-coherence.mp4',
                'miniature' => '/images/feed/design-system.jpg',
                'duree' => 720, // 12 minutes
                'user_id' => 3, // Fatou Sall
                'categorie_id' => 3, // Design
                'est_public' => true,
            ],
            [
                'titre' => 'Sécurité Web : Les Erreurs à Éviter',
                'description' => 'Les 10 erreurs de sécurité les plus courantes dans le développement web et comment les éviter.',
                'url_video' => '/videos/feed/securite-erreurs-eviter.mp4',
                'miniature' => '/images/feed/securite-web.jpg',
                'duree' => 900, // 15 minutes
                'user_id' => 4, // Ousmane Ba
                'categorie_id' => 5, // Cybersécurité
                'est_public' => true,
            ],
            [
                'titre' => 'React vs Vue.js : Quel Framework Choisir ?',
                'description' => 'Comparaison détaillée entre React et Vue.js pour vous aider à faire le bon choix.',
                'url_video' => '/videos/feed/react-vs-vue.mp4',
                'miniature' => '/images/feed/react-vs-vue.jpg',
                'duree' => 1080, // 18 minutes
                'user_id' => 2, // Amadou Diallo
                'categorie_id' => 1, // Développement Web
                'est_public' => true,
            ],
            [
                'titre' => 'UX Research : Méthodes et Outils',
                'description' => 'Les meilleures méthodes et outils pour mener une recherche UX efficace.',
                'url_video' => '/videos/feed/ux-research-methodes.mp4',
                'miniature' => '/images/feed/ux-research.jpg',
                'duree' => 960, // 16 minutes
                'user_id' => 3, // Fatou Sall
                'categorie_id' => 3, // Design
                'est_public' => true,
            ],
            [
                'titre' => 'Flutter : Créer sa Première App',
                'description' => 'Tutorial complet pour créer votre première application mobile avec Flutter.',
                'url_video' => '/videos/feed/flutter-premiere-app.mp4',
                'miniature' => '/images/feed/flutter-app.jpg',
                'duree' => 1800, // 30 minutes
                'user_id' => 4, // Ousmane Ba
                'categorie_id' => 2, // Mobile
                'est_public' => true,
            ],
            [
                'titre' => 'Tendances Design 2024',
                'description' => 'Les tendances design à suivre en 2024 pour rester à la pointe.',
                'url_video' => '/videos/feed/tendances-design-2024.mp4',
                'miniature' => '/images/feed/tendances-2024.jpg',
                'duree' => 600, // 10 minutes
                'user_id' => 3, // Fatou Sall
                'categorie_id' => 3, // Design
                'est_public' => true,
            ],
        ];

        // Créer les vidéos du feed
        foreach ($feedVideos as $index => $videoData) {
            $video = FeedVideo::create($videoData);

            // Ajouter des likes, vues et partages aléatoirement
            $this->addEngagementData($video, $index + 1);
        }
    }

    private function addEngagementData($video, $videoIndex)
    {
        // Ajouter des vues (entre 50 et 500)
        $viewsCount = rand(50, 500);
        for ($i = 0; $i < $viewsCount; $i++) {
            FeedVideoView::create([
                'feed_video_id' => $video->id,
                'user_id' => rand(1, 9), // Utilisateurs aléatoires
                'created_at' => now()->subDays(rand(0, 30)),
            ]);
        }

        // Ajouter des likes (entre 5 et 50)
        $likesCount = rand(5, 50);
        $likedUsers = [];
        for ($i = 0; $i < $likesCount; $i++) {
            $userId = rand(1, 9);
            if (!in_array($userId, $likedUsers)) {
                FeedVideoLike::create([
                    'feed_video_id' => $video->id,
                    'user_id' => $userId,
                    'created_at' => now()->subDays(rand(0, 30)),
                ]);
                $likedUsers[] = $userId;
            }
        }

        // Ajouter des partages (entre 1 et 10)
        $sharesCount = rand(1, 10);
        for ($i = 0; $i < $sharesCount; $i++) {
            FeedVideoShare::create([
                'feed_video_id' => $video->id,
                'user_id' => rand(1, 9),
                'platform' => ['facebook', 'twitter', 'linkedin', 'whatsapp'][rand(0, 3)],
                'created_at' => now()->subDays(rand(0, 30)),
            ]);
        }
    }
}
