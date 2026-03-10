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
        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary()->comment('Identifiant unique de la session');
            $table->foreignId('user_id')->nullable()->index()->comment('Référence vers l’utilisateur connecté, nullable si invité');
            $table->string('ip_address', 45)->nullable()->comment('Adresse IP de l’utilisateur, IPv4 ou IPv6');
            $table->text('user_agent')->nullable()->comment('Chaîne User-Agent du navigateur ou client utilisé');
            $table->longText('payload')->comment('Données sérialisées de la session');
            $table->integer('last_activity')->index()->comment('Horodatage de la dernière activité de la session, indexé pour recherche rapide');
        });
    }

    /**
     * Annuler les migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sessions');
    }
};
