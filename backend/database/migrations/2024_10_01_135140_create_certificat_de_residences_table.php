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
        Schema::create('certificat_de_residences', function (Blueprint $table) {
            $table->id();
            $table->string('nom_complet_du_resident'); // Nom complet du résident
            $table->string('adresse_actuelle_de_la_residence'); // Adresse actuelle de la résidence
            $table->string('preuve_de_residence'); // Preuve de résidence
            $table->string('carte_identite_du_resident'); // Carte d'identité du résident
            $table->string('declaration_sur_l_honneur'); // Déclaration sur l'honneur
            $table->foreignId('demande_id')->constrained()->onDelete('cascade'); // Clé étrangère pour demande_id
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('certificat_de_residences');
    }
};
