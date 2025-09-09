<?php

namespace Database\Factories;

use App\Models\Formation;
use App\Models\FormationSection;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\LessonVideo>
 */
class LessonVideoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'formation_id' => Formation::factory(),
            'formation_section_id' => FormationSection::factory(),
            'titre' => $this->faker->sentence(4),
            'url_video' => '/storage/lessons/' . $this->faker->uuid() . '.mp4',
            'ordre' => $this->faker->numberBetween(1, 20),
            'duree' => $this->faker->numberBetween(60, 3600), // 1 minute à 1 heure
            'est_gratuit' => $this->faker->boolean(30), // 30% de chance d'être gratuit
        ];
    }
}