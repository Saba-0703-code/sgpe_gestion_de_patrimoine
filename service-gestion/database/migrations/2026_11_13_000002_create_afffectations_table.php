<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('affectations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('bien_id');
            $table->string('nom_responsable');
            $table->string('service_departement');
            $table->text('motif')->nullable();
            $table->date('date_affectation');
            $table->date('date_retour')->nullable();
            $table->enum('statut', ['en_cours', 'retourne', 'perdu'])->default('en_cours');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('affectations');
    }
};
