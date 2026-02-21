<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            // Génération de l'UUID pour le champ id
            'id' => (string) Str::uuid(), 
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            // 'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password123'),
            // 'remember_token' => Str::random(10),
            
            // Ajout des champs obligatoires pour ton projet
            'status' => fake()->randomElement(['active', 'inactive', 'suspended']),
            'role' => fake()->randomElement(['admin', 'user']),
        ];
    }

    /**
     * État non vérifié (optionnel)
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}