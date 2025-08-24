<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            // Ordre important : les dépendances d'abord
            UserSeeder::class,              // 1. Utilisateurs (admin, formateurs, apprenants)
            CategorieSeeder::class,         // 2. Catégories
            PaymentMethodSeeder::class,     // 3. Moyens de paiement (TouchPoint)
            FormationSeeder::class,         // 4. Formations (avec objectifs et sections)
            LessonVideoSeeder::class,       // 5. Vidéos de cours
            FeedVideoSeeder::class,         // 6. Vidéos du feed (avec engagement)
            PurchaseSeeder::class,          // 7. Achats et inscriptions
        ]);

        $this->command->info('🎉 Base de données seedée avec succès !');
        $this->command->info('📊 Données créées :');
        $this->command->info('   - 9 utilisateurs (1 admin, 3 formateurs, 5 apprenants)');
        $this->command->info('   - 8 catégories de formation');
        $this->command->info('   - 2 moyens de paiement TouchPoint (Orange Money, Wave)');
        $this->command->info('   - 6 formations avec objectifs et sections');
        $this->command->info('   - 15+ vidéos de cours');
        $this->command->info('   - 7 vidéos du feed avec engagement');
        $this->command->info('   - 7 achats (5 complétés, 2 en attente)');
        $this->command->info('   - 5 inscriptions actives');
        $this->command->info('');
        $this->command->info('🔑 Comptes de test :');
        $this->command->info('   Admin: admin@bintschool.com / password');
        $this->command->info('   Formateur: amadou@bintschool.com / password');
        $this->command->info('   Apprenant: test@example.com / password');
    }
}
