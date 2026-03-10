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
        Schema::create('personal_access_tokens', function (Blueprint $table) {
            $table->id()->comment('Identifiant unique du token');
            
            // uuidMorphs crée deux colonnes : tokenable_id (UUID) et tokenable_type (string)
            $table->uuidMorphs('tokenable'); 
            // tokenable_id : Identifiant UUID de l’entité liée (ex. utilisateur)
            // tokenable_type : Type de l’entité liée (ex. App\\Models\\User)

            $table->text('name')->comment('Nom descriptif du token, utile pour l’identifier');
            $table->string('token', 64)->unique()->comment('Valeur hachée du jeton d’accès, unique');
            $table->text('abilities')->nullable()->comment('Permissions accordées au token, sous forme de liste');
            $table->timestamp('last_used_at')->nullable()->comment('Date et heure de la dernière utilisation du token');
            $table->timestamp('expires_at')->nullable()->index()->comment('Date et heure d’expiration du token, indexée pour les recherches rapides');
            $table->timestamps(); // created_at et updated_at
        });
    }

    /**
     * Annuler les migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('personal_access_tokens');
    }
};
