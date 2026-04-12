<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
            DB::transaction(function() {
                // 1. Super Admin
                User::factory()->create([
                    'name' => 'Admin Conceptic',
                    'email' => 'admin@conceptic.io',
                    'password' => bcrypt('Adminconceptic@123'),
                    'role' => 'admin',
                    'status' => 'active',
                ]);

                // 2. Créer l'utilisateur de test POstman
                User::factory()->create([
                    'name' => 'Abdoul Rachid',
                    'email' => 'rachidbissare@gmail.com',
                    'password' => bcrypt('AbdoulRachid@123'),
                ]); 

                // 3. Créer 28 utilisateurs aléatoires
                User::factory()->count(22)->create([
                    'password' => bcrypt('passwordUser'),
                ]);
            });
    }
}
