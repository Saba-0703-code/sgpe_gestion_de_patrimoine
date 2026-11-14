<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('biens', function (Blueprint $table) {
            $table->id();
            $table->string('designation');
            $table->text('description')->nullable();
            $table->string('categorie');
            $table->string('marque')->nullable();
            $table->string('modele')->nullable();
            $table->string('numero_serie')->nullable()->unique();
            $table->date('date_achat')->nullable();
            $table->decimal('valeur', 15, 2)->default(0);
            $table->enum('etat', ['Neuf', 'Bon', 'Moyen', 'Dégradé', 'Hors service'])->default('Bon');
            $table->string('emplacement')->nullable();
            $table->string('responsable')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('biens');
    }
};
