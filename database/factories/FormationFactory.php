<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Formation>
 */
class FormationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'formateur_id' => User::factory(),
            'titre' => $this->faker->sentence(4),
            'description' => $this->faker->paragraphs(3, true),
            'prix' => $this->faker->numberBetween(0, 50000), // en centimes
            'duree_estimee' => $this->faker->numberBetween(30, 300), // en minutes
            'niveau' => $this->faker->randomElement(['debutant', 'intermediaire', 'avance']),
            'langue' => $this->faker->randomElement(['fr', 'en', 'es']),
            'statut' => $this->faker->randomElement(['brouillon', 'publie']),
            'image_couverture' => $this->faker->imageUrl(800, 600, 'education'),
            'video_preview' => null,
            'certificat_disponible' => $this->faker->boolean(30),
            'categorie_id' => 1, // Assumons qu'il y a au moins une catégorie
        ];
    }
}
