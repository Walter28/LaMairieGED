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
        Schema::create('certificat_de_deces', function (Blueprint $table) {
            $table->id();
            $table->foreignId('demande_id')->constrained()->onDelete('cascade'); // Ajout de la clé étrangère
            $table->string('nom_complet_defunt');
            $table->date('date_de_deces');
            $table->string('lieu_de_deces');
            $table->string('certificat_medical_deces'); // chemin du fichier
            $table->string('preuve_identite_defunt'); // chemin du fichier
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('certificat_de_deces');
    }
};
