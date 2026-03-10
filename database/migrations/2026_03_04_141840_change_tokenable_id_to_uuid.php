<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Migration pour transformer la colonne tokenable_id en UUID
     */
    public function up(): void
    {
        Schema::table('personal_access_tokens', function (Blueprint $table) {
            // Identifiant UUID de l’entité liée au token (ex. utilisateur)
            $table->uuid('tokenable_id')->comment('Identifiant UUID de l’entité liée au token')->change();
        });
    } // end of up

    /**
     * Annuler la migration et revenir à bigint
     */
    public function down(): void
    {
        Schema::table('personal_access_tokens', function (Blueprint $table) {
            // Identifiant numérique (bigint) de l’entité liée au token
            $table->bigInteger('tokenable_id')->comment('Identifiant numérique de l’entité liée au token')->change();
        });
    } // end of down
};
