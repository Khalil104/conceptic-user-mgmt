<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            $table->uuid('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('action'); // ex: 'login_success', 'user_created, 'login_failed', 'user_deleted', '2fa_failed', 'user_updated'
            $table->string('description'); // Modification de l'email par l'admin
            $table->json('changes')->nullable(); // Pourstocker d'anciennes/nouvelles valeurs
            $table->string('ip_address')->nullable();
            $table->string('user_agent')-> nullale();
            $table->timestamps();
            });
            }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
    }
};
