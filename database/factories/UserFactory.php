<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

// Usine à données fictives : permet de définir des plans de construction (blueprint)
// pour créer automatiquement des enregistrements dans la db

class UserFactory extends Factory  {

    protected static ?string $password;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array {
        return [
            // Génération de l'UUID pour le champ id
            'id' => (string) Str::uuid(), 
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            // 'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password123'),
            // 'remember_token' => Str::random(10),
            
            // Ajout des champs obligatoires
            'status' => fake()->randomElement(['active', 'inactive', 'suspended']),
            'role' => fake()->randomElement(['admin', 'user']),
        ];
    } // end of the function definition()

    /**
     * État non vérifié (optionnel)
     */
    public function unverified(): static {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    } // end of the function unverified
}