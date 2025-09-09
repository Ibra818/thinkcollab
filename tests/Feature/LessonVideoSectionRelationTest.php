<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Formation;
use App\Models\FormationSection;
use App\Models\LessonVideo;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LessonVideoSectionRelationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function lesson_video_belongs_to_formation_section()
    {
        // Créer un utilisateur formateur
        $user = User::factory()->create(['role' => 'formateur']);
        
        // Créer une formation
        $formation = Formation::factory()->create(['formateur_id' => $user->id]);
        
        // Créer une section de formation
        $section = FormationSection::factory()->create([
            'formation_id' => $formation->id,
            'titre' => 'Introduction',
            'ordre' => 1
        ]);
        
        // Créer une vidéo de leçon liée à la section
        $lessonVideo = LessonVideo::factory()->create([
            'formation_id' => $formation->id,
            'formation_section_id' => $section->id,
            'titre' => 'Vidéo d\'introduction',
            'ordre' => 1
        ]);
        
        // Vérifier la relation
        $this->assertInstanceOf(FormationSection::class, $lessonVideo->section);
        $this->assertEquals($section->id, $lessonVideo->section->id);
        $this->assertEquals('Introduction', $lessonVideo->section->titre);
    }

    /** @test */
    public function formation_section_has_many_lesson_videos()
    {
        // Créer un utilisateur formateur
        $user = User::factory()->create(['role' => 'formateur']);
        
        // Créer une formation
        $formation = Formation::factory()->create(['formateur_id' => $user->id]);
        
        // Créer une section de formation
        $section = FormationSection::factory()->create([
            'formation_id' => $formation->id,
            'titre' => 'Chapitre 1',
            'ordre' => 1
        ]);
        
        // Créer plusieurs vidéos de leçon liées à la section
        $lessonVideo1 = LessonVideo::factory()->create([
            'formation_id' => $formation->id,
            'formation_section_id' => $section->id,
            'titre' => 'Vidéo 1',
            'ordre' => 1
        ]);
        
        $lessonVideo2 = LessonVideo::factory()->create([
            'formation_id' => $formation->id,
            'formation_section_id' => $section->id,
            'titre' => 'Vidéo 2',
            'ordre' => 2
        ]);
        
        // Vérifier la relation
        $this->assertCount(2, $section->lessonVideos);
        $this->assertTrue($section->lessonVideos->contains($lessonVideo1));
        $this->assertTrue($section->lessonVideos->contains($lessonVideo2));
    }

    /** @test */
    public function lesson_videos_are_ordered_correctly()
    {
        // Créer un utilisateur formateur
        $user = User::factory()->create(['role' => 'formateur']);
        
        // Créer une formation
        $formation = Formation::factory()->create(['formateur_id' => $user->id]);
        
        // Créer une section de formation
        $section = FormationSection::factory()->create([
            'formation_id' => $formation->id,
            'titre' => 'Chapitre 1',
            'ordre' => 1
        ]);
        
        // Créer des vidéos avec des ordres différents
        $lessonVideo3 = LessonVideo::factory()->create([
            'formation_id' => $formation->id,
            'formation_section_id' => $section->id,
            'titre' => 'Vidéo 3',
            'ordre' => 3
        ]);
        
        $lessonVideo1 = LessonVideo::factory()->create([
            'formation_id' => $formation->id,
            'formation_section_id' => $section->id,
            'titre' => 'Vidéo 1',
            'ordre' => 1
        ]);
        
        $lessonVideo2 = LessonVideo::factory()->create([
            'formation_id' => $formation->id,
            'formation_section_id' => $section->id,
            'titre' => 'Vidéo 2',
            'ordre' => 2
        ]);
        
        // Récupérer les vidéos ordonnées
        $orderedVideos = $section->lessonVideos;
        
        // Vérifier l'ordre
        $this->assertEquals('Vidéo 1', $orderedVideos[0]->titre);
        $this->assertEquals('Vidéo 2', $orderedVideos[1]->titre);
        $this->assertEquals('Vidéo 3', $orderedVideos[2]->titre);
    }

    /** @test */
    public function formation_section_can_calculate_total_duration()
    {
        // Créer un utilisateur formateur
        $user = User::factory()->create(['role' => 'formateur']);
        
        // Créer une formation
        $formation = Formation::factory()->create(['formateur_id' => $user->id]);
        
        // Créer une section de formation
        $section = FormationSection::factory()->create([
            'formation_id' => $formation->id,
            'titre' => 'Chapitre 1',
            'ordre' => 1
        ]);
        
        // Créer des vidéos avec des durées différentes
        LessonVideo::factory()->create([
            'formation_id' => $formation->id,
            'formation_section_id' => $section->id,
            'titre' => 'Vidéo 1',
            'duree' => 300, // 5 minutes
            'ordre' => 1
        ]);
        
        LessonVideo::factory()->create([
            'formation_id' => $formation->id,
            'formation_section_id' => $section->id,
            'titre' => 'Vidéo 2',
            'duree' => 600, // 10 minutes
            'ordre' => 2
        ]);
        
        // Vérifier la durée totale
        $this->assertEquals(900, $section->total_duration); // 15 minutes total
    }

    /** @test */
    public function formation_section_can_count_videos()
    {
        // Créer un utilisateur formateur
        $user = User::factory()->create(['role' => 'formateur']);
        
        // Créer une formation
        $formation = Formation::factory()->create(['formateur_id' => $user->id]);
        
        // Créer une section de formation
        $section = FormationSection::factory()->create([
            'formation_id' => $formation->id,
            'titre' => 'Chapitre 1',
            'ordre' => 1
        ]);
        
        // Créer 3 vidéos
        LessonVideo::factory()->count(3)->create([
            'formation_id' => $formation->id,
            'formation_section_id' => $section->id
        ]);
        
        // Vérifier le nombre de vidéos
        $this->assertEquals(3, $section->videos_count);
    }

    /** @test */
    public function lesson_video_can_be_created_without_section()
    {
        // Créer un utilisateur formateur
        $user = User::factory()->create(['role' => 'formateur']);
        
        // Créer une formation
        $formation = Formation::factory()->create(['formateur_id' => $user->id]);
        
        // Créer une vidéo sans section
        $lessonVideo = LessonVideo::factory()->create([
            'formation_id' => $formation->id,
            'formation_section_id' => null,
            'titre' => 'Vidéo sans section',
            'ordre' => 1
        ]);
        
        // Vérifier que la vidéo existe
        $this->assertDatabaseHas('lesson_videos', [
            'id' => $lessonVideo->id,
            'formation_section_id' => null
        ]);
        
        // Vérifier que la relation retourne null
        $this->assertNull($lessonVideo->section);
    }
}