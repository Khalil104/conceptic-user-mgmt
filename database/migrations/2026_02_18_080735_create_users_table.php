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
            $table->uuid('id')->primary()->comment('Identifiant unique universel UUID');  
            $table->string('name')->comment("Nom et prénom de l'utilisateur"); 
            $table->string('email')->unique()->comment('Adresse de messagerie unique');
            $table->string('password')->comment('Empreinte hachée du mot de passe');
            $table->enum('status', ['inactive', 'active', 'suspended', 'deleted'])->default('active')->comment(' Statut possible de l\'utilisateur : Par défaut actif');
            $table->enum ('role', ['admin', 'user'])->default('user')->comment(' Rôle possible : par défaut user');
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
