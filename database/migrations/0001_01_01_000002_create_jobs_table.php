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
        Schema::create('jobs', function (Blueprint $table) {
            $table->id()->comment('Identifiant unique du job');
            $table->string('queue')->index()->comment('Nom de la file de traitement associée au job');
            $table->longText('payload')->comment('Contenu sérialisé du job à exécuter');
            $table->unsignedTinyInteger('attempts')->comment('Nombre de tentatives déjà effectuées pour ce job');
            $table->unsignedInteger('reserved_at')->nullable()->comment('Horodatage indiquant quand le job a été réservé pour exécution');
            $table->unsignedInteger('available_at')->comment('Horodatage indiquant quand le job devient disponible');
            $table->unsignedInteger('created_at')->comment('Horodatage de création du job');
        });

        Schema::create('job_batches', function (Blueprint $table) {
            $table->string('id')->primary()->comment('Identifiant unique du lot de jobs');
            $table->string('name')->comment('Nom descriptif du lot de jobs');
            $table->integer('total_jobs')->comment('Nombre total de jobs dans le lot');
            $table->integer('pending_jobs')->comment('Nombre de jobs en attente dans le lot');
            $table->integer('failed_jobs')->comment('Nombre de jobs échoués dans le lot');
            $table->longText('failed_job_ids')->comment('Liste des identifiants des jobs échoués');
            $table->mediumText('options')->nullable()->comment('Options de configuration du lot de jobs');
            $table->integer('cancelled_at')->nullable()->comment('Horodatage de l’annulation du lot');
            $table->integer('created_at')->comment('Horodatage de création du lot');
            $table->integer('finished_at')->nullable()->comment('Horodatage de fin du lot');
        });

        Schema::create('failed_jobs', function (Blueprint $table) {
            $table->id()->comment('Identifiant unique du job échoué');
            $table->string('uuid')->unique()->comment('Identifiant UUID unique du job échoué');
            $table->text('connection')->comment('Nom de la connexion utilisée pour exécuter le job');
            $table->text('queue')->comment('Nom de la file dans laquelle le job était placé');
            $table->longText('payload')->comment('Contenu sérialisé du job échoué');
            $table->longText('exception')->comment('Trace de l’exception ayant provoqué l’échec');
            $table->timestamp('failed_at')->useCurrent()->comment('Horodatage de l’échec du job');
        });
    }

    /**
     * Annuler les migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jobs');
        Schema::dropIfExists('job_batches');
        Schema::dropIfExists('failed_jobs');
    }
};
