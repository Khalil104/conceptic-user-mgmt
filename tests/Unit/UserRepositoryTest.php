<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserRepositoryTest extends TestCase {
    use RefreshDatabase;

    public function test_user_model_generates_uuid() {
        $user = User::create([
            'name'     => 'Test UUID',
            'email'    => 'uuid@example.com',
            'password' => 'password123',
            'status'   => 'active',
            'role'     => 'user'
        ]); // end of the function test_user_model_generates_uuid()

        // Vérifie que l'ID n'est pas un entier mais une chaîne (UUID)
        $this->assertIsString($user->id);
        $this->assertEquals(36, strlen($user->id)); 
    }

    public function test_password_is_automatically_hashed() {
        $password = 'secret123';
        $user = User::factory()->create(['password' => $password]);

        // Vérifie que le mot de passe en base n'est pas en clair
        $this->assertNotEquals($password, $user->password);
        
        // Vérifie que le hachage est valide
        $this->assertTrue(Hash::check($password, $user->password));
    } // end of the function test_password_is_automatically_hashed()

    public function test_password_is_hidden_in_json() {
        $user = User::factory()->make();
        $array = $user->toArray();

        // Le password ne doit pas apparaître lors de la conversion en tableau/JSON
        $this->assertArrayNotHasKey('password', $array);
    } // end of the function test_password_is_hidden_in_json()
} // end of the class UserRepositoryTest--extends

// php artisan test --testsuite=Unit : Tester un type de test donné. 