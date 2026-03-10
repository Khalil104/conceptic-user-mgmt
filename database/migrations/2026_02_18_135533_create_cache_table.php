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
        Schema::create('cache', function (Blueprint $table) {
            $table->string('key')->primary()->comment('Clé unique identifiant l’entrée de cache');
            $table->mediumText('value')->comment('Valeur sérialisée stockée dans le cache');
            $table->integer('expiration')->comment('Horodatage indiquant la date d’expiration de l’entrée');
        });

        Schema::create('cache_locks', function (Blueprint $table) {
            $table->string('key')->primary()->comment('Clé unique identifiant le verrou de cache');
            $table->string('owner')->comment('Identifiant du propriétaire du verrou');
            $table->integer('expiration')->comment('Horodatage indiquant la date d’expiration du verrou');
        });
    }

    /**
     * Annuler les migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cache');
        Schema::dropIfExists('cache_locks');
    }
};
