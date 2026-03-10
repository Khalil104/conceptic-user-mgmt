<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    /**
     * Faire des modifications
     */
    public function up(): void {

        Schema::create('users', function (Blueprint $table) {
            // id = Nom de la colonne incrémenté
            //  id != uuid = identifiant unique au monde de l'utilisateur 
            $table->uuid('id')->primary(); 

            // Nom de l'utilisateur 
            $table->string('name')->comment("Nom de l'utilisateur"); 

            // Email de l'utilisateur : unique
            $table->string('email')->unique();

            // Mot de password de l'utilisateur à haché
            $table->string('password');

            // statut possible de l'utilisateur : Par défaut actif 
            $table->enum('status', ['inactive', 'active', 'suspended', 'deleted'])->default('active');
            
            // rôle possible : par défaut utilisateur
            $table->enum ('role', ['admin', 'user'])->default('user');

            // timestamps ->create_at() et updated_at()
            $table->timestamps();
        });
    } //end of the function up !

    /**
     * Annuler des modifications
     */
    public function down(): void {
        Schema::dropIfExists('users');
    } // end of the function down
};
