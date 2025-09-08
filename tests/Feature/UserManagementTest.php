<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

class UserManagementTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();
    }

    /** @test */
    public function it_can_create_user_without_role()
    {
        $userData = [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'password' => 'password123',
        ];

        $response = $this->postJson('/api/users', $userData);

        $response->assertStatus(201)
                ->assertJson([
                    'success' => true,
                    'message' => 'Utilisateur créé avec succès'
                ]);

        $this->assertDatabaseHas('users', [
            'name' => $userData['name'],
            'email' => $userData['email'],
            'role' => null
        ]);
    }

    /** @test */
    public function it_can_create_user_with_role()
    {
        $userData = [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'password' => 'password123',
            'role' => 'apprenant'
        ];

        $response = $this->postJson('/api/users', $userData);

        $response->assertStatus(201)
                ->assertJson([
                    'success' => true,
                    'message' => 'Utilisateur créé avec succès'
                ]);

        $this->assertDatabaseHas('users', [
            'name' => $userData['name'],
            'email' => $userData['email'],
            'role' => 'apprenant'
        ]);
    }

    /** @test */
    public function it_validates_required_fields()
    {
        $response = $this->postJson('/api/users', []);

        $response->assertStatus(422)
                ->assertJsonValidationErrors(['name', 'email', 'password']);
    }

    /** @test */
    public function it_validates_email_uniqueness()
    {
        $existingUser = User::factory()->create();

        $userData = [
            'name' => $this->faker->name,
            'email' => $existingUser->email,
            'password' => 'password123',
        ];

        $response = $this->postJson('/api/users', $userData);

        $response->assertStatus(422)
                ->assertJsonValidationErrors(['email']);
    }

    /** @test */
    public function it_validates_password_length()
    {
        $userData = [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'password' => '123',
        ];

        $response = $this->postJson('/api/users', $userData);

        $response->assertStatus(422)
                ->assertJsonValidationErrors(['password']);
    }

    /** @test */
    public function it_validates_role_values()
    {
        $userData = [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'password' => 'password123',
            'role' => 'invalid_role'
        ];

        $response = $this->postJson('/api/users', $userData);

        $response->assertStatus(422)
                ->assertJsonValidationErrors(['role']);
    }

    /** @test */
    public function it_can_get_all_users()
    {
        User::factory()->count(5)->create();

        $response = $this->getJson('/api/users');

        $response->assertStatus(200)
                ->assertJson([
                    'success' => true
                ])
                ->assertJsonCount(5, 'users');
    }

    /** @test */
    public function it_can_filter_users_by_role()
    {
        User::factory()->create(['role' => 'apprenant']);
        User::factory()->create(['role' => 'formateur']);
        User::factory()->create(['role' => null]);

        $response = $this->getJson('/api/users?role=apprenant');

        $response->assertStatus(200)
                ->assertJsonCount(1, 'users');
    }

    /** @test */
    public function it_can_search_users()
    {
        $user1 = User::factory()->create(['name' => 'John Doe']);
        $user2 = User::factory()->create(['name' => 'Jane Smith']);

        $response = $this->getJson('/api/users?search=John');

        $response->assertStatus(200)
                ->assertJsonCount(1, 'users')
                ->assertJsonPath('users.0.name', 'John Doe');
    }

    /** @test */
    public function it_can_get_user_by_id()
    {
        $user = User::factory()->create();

        $response = $this->getJson("/api/users/{$user->id}");

        $response->assertStatus(200)
                ->assertJson([
                    'success' => true,
                    'user' => [
                        'id' => $user->id,
                        'name' => $user->name,
                        'email' => $user->email
                    ]
                ]);
    }

    /** @test */
    public function it_returns_404_for_nonexistent_user()
    {
        $response = $this->getJson('/api/users/999');

        $response->assertStatus(404);
    }

    /** @test */
    public function it_can_update_user()
    {
        $user = User::factory()->create();

        $updateData = [
            'name' => 'Updated Name',
            'email' => 'updated@email.com',
            'role' => 'formateur'
        ];

        $response = $this->putJson("/api/users/{$user->id}", $updateData);

        $response->assertStatus(200)
                ->assertJson([
                    'success' => true,
                    'message' => 'Utilisateur mis à jour avec succès'
                ]);

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => 'Updated Name',
            'email' => 'updated@email.com',
            'role' => 'formateur'
        ]);
    }

    /** @test */
    public function it_can_update_user_role_only()
    {
        $user = User::factory()->create(['role' => 'apprenant']);

        $response = $this->putJson("/api/users/{$user->id}/role", [
            'role' => 'formateur'
        ]);

        $response->assertStatus(200)
                ->assertJson([
                    'success' => true,
                    'message' => 'Rôle mis à jour avec succès'
                ]);

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'role' => 'formateur'
        ]);
    }

    /** @test */
    public function it_can_delete_user()
    {
        $user = User::factory()->create();

        $response = $this->deleteJson("/api/users/{$user->id}");

        $response->assertStatus(200)
                ->assertJson([
                    'success' => true,
                    'message' => 'Utilisateur supprimé avec succès'
                ]);

        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }

    /** @test */
    public function it_can_get_user_statistics()
    {
        User::factory()->count(3)->create(['role' => 'apprenant']);
        User::factory()->count(2)->create(['role' => 'formateur']);
        User::factory()->count(1)->create(['role' => null]);

        $response = $this->getJson('/api/users-statistics');

        $response->assertStatus(200)
                ->assertJson([
                    'success' => true,
                    'statistics' => [
                        'total_users' => 6,
                        'apprenants' => 3,
                        'formateurs' => 2,
                        'users_without_role' => 1
                    ]
                ]);
    }

    /** @test */
    public function it_can_reset_user_password()
    {
        $user = User::factory()->create();

        $response = $this->postJson("/api/users/{$user->id}/reset-password", [
            'new_password' => 'newpassword123'
        ]);

        $response->assertStatus(200)
                ->assertJson([
                    'success' => true,
                    'message' => 'Mot de passe réinitialisé avec succès'
                ]);

        // Vérifier que le mot de passe a été changé
        $user->refresh();
        $this->assertTrue(\Hash::check('newpassword123', $user->password));
    }

    /** @test */
    public function it_validates_new_password_length()
    {
        $user = User::factory()->create();

        $response = $this->postJson("/api/users/{$user->id}/reset-password", [
            'new_password' => '123'
        ]);

        $response->assertStatus(422)
                ->assertJsonValidationErrors(['new_password']);
    }
}

