<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Exécuter les migrations.
     */
    public function up(): void
    {
        Schema::create('verification_codes', function (Blueprint $table) {
            $table->id()->comment('Identifiant unique du code de vérification');
            
            $table->foreignUuid('user_id')
                ->constrained()
                ->onDelete('cascade')
                ->comment('Identifiant UUID de l’utilisateur associé au code, suppression en cascade si l’utilisateur est supprimé');
            
            $table->string('code')->comment('Valeur du code de vérification généré');
            
            $table->timestamp('expires_at')->comment('Date et heure d’expiration du code de vérification');
            
            $table->timestamps(); // created_at et updated_at
        });
    }

    /**
     * Annuler les migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('verification_codes');
    }
};