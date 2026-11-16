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
            $table->unsignedBigInteger('bien_id')->nullable();
            $table->string('nom_bien');
            $table->string('service_destinataire');
            $table->string('responsable');
            $table->date('date_affectation');
            $table->date('date_fin')->nullable();
            $table->text('motif')->nullable();
            $table->string('etat')->default('En cours');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('affectations');
    }
};
