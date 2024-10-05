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
        Schema::create('carte_identite_nationales', function (Blueprint $table) {
            $table->id();
            $table->string('nom_complet_citoyen');
            $table->date('date_de_naissance');
            $table->string('lieu_de_naissance');
            $table->string('adresse_actuelle');
            $table->string('photo_identite'); // stocke le chemin du fichier
            $table->string('preuve_identite'); // stocke le chemin du fichier
            $table->string('empreintes_digitales'); // stocke le chemin du fichier
            $table->foreignId('demande_id')->constrained()->onDelete('cascade'); // clé étrangère
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carte_identite_nationales');
    }
};
