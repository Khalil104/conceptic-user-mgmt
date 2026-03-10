<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder 
{

    /**
     * Seed the application's database.
     */
   public function run(): void {
        // 1. Compte de test principal (Identifiants fixes)
        User::factory()->create([
            'name' => 'Abdoul Rachid',
            'email' => 'abdoulrachid@gmail.com', // Celui UTILISER dans Postman
            'password' => bcrypt('password'), //Définition d'un mot de passe connu
        ]);

        // 2. Créer 10 utilisateurs aléatoires pour "remplir" le dashboard
        User::factory(10)->create();
    }// end of the function run

} // end of the class
