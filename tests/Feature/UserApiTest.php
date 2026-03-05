<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserApiTest extends TestCase  {

    use RefreshDatabase;

    // 
    public function test_can_create_user()  {
        $userData = [
            'name' => 'Rachid Test',
            'email' => 'rachid@example.com',
            'password' => 'password123',
            'status' => 'active',
            'role' => 'admin',
        ];

        $response = $this->postJson('/api/users', $userData);

        $response->assertStatus(201)
                 ->assertJsonPath('success', true)
                 ->assertJsonStructure(['data' => ['id', 'name', 'email']]);
        
        $this->assertDatabaseHas('users', ['email' => 'rachid@example.com']);
    } // end of function test_can_create_user()

    //
    public function test_can_list_and_filter_users() {
        $uniqueName = 'User_Unique_Test_99';
        User::factory()->create(['name' => $uniqueName, 'role' => 'admin', 'status'=> 'active']);
        User::factory()->create(['name' => 'Other User', 'role' => 'user']);

        // Test filtre par NOM
        $response = $this->getJson("/api/users?name={$uniqueName}");
        $response->assertStatus(200)
                 ->assertJsonCount(1, 'data')
                 ->assertJsonFragment(['name' => $uniqueName]);

        // Test filtre par RÔLE
        $response = $this->getJson('/api/users?role=admin');
        $response->assertStatus(200);
        
        foreach ($response->json('data') as $user) {
            $this->assertEquals('admin', $user['role']);
        }
    } // end of the  function test_can_list_and_filter_users()

    public function test_can_show_user_detail() {
        $user = User::factory()->create();

        $response = $this->getJson("/api/users/{$user->id}");
        
        $response->assertStatus(200)
                 ->assertJsonPath('data.id', $user->id);
    } // end of the test_can_show_user_detail() 

    public function test_can_update_user() {
        $user = User::factory()->create(['name' => 'Ancien Nom']);

        $response = $this->putJson("/api/users/{$user->id}", [
            'name' => 'Nom Modifie',
            'status' => 'suspended'
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('users', [
            'id' => $user->id, 
            'name' => 'Nom Modifie',
            'status' => 'suspended'
        ]);
    } // end of the function test_can_update_user()

    public function test_can_delete_user() {
        $user = User::factory()->create();

        $response = $this->deleteJson("/api/users/{$user->id}");

        $response->assertStatus(200);
        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    } // end of the function test_can_update_user()

    public function test_validation_blocks_empty_request() {
        $response = $this->postJson('/api/users', []);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['name', 'email', 'password']);
    } // end of the function test_validation_blocks_empty_request()
}