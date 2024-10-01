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
        Schema::create('permis_de_construires', function (Blueprint $table) {
            $table->id();
            $table->string('nom_demandeur');
            $table->string('adresse_site_construction');
            $table->string('plans_construction'); // Chemin vers le fichier
            $table->string('permis_urbanisme')->nullable(); // Chemin vers le fichier (peut être null)
            $table->string('preuve_propriete_terrain'); // Chemin vers le fichier
            $table->string('preuve_identite'); // Chemin vers le fichier
            $table->foreignId('demande_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permis_de_construires');
    }
};
