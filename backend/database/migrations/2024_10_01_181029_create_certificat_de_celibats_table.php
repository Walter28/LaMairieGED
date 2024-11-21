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
        Schema::create('certificat_de_celibats', function (Blueprint $table) {
            $table->id();
            $table->string('nom_complet_celibataire');
            $table->date('date_naissance');
            $table->string('lieu_naissance');
            $table->string('preuve_identite');
            $table->string('acte_naissance');
            $table->string('declaration_honneur');
            $table->foreignId('demande_id')->constrained()->onDelete('cascade'); // clé étrangère
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('certificat_de_celibats');
    }
};
