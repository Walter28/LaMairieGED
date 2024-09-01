<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('type_documents', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->text('description')->nullable();
            $table->timestamps();
        });

        // Ajout des entrées par défaut
        DB::table('type_documents')->insert([
            ['id' => 1, 'nom' => 'Acte de naissance', 'description' => null],
            ['id' => 2, 'nom' => 'Acte de mariage', 'description' => null],
            ['id' => 3, 'nom' => 'Certificat de décès', 'description' => null],
            ['id' => 4, 'nom' => 'Certificat de résidence', 'description' => null],
            ['id' => 5, 'nom' => 'Carte d\'identité nationale', 'description' => null],
            ['id' => 6, 'nom' => 'Certificat de célibat', 'description' => null],
            ['id' => 7, 'nom' => 'Permis de conduire', 'description' => null],
            ['id' => 8, 'nom' => 'Attestation de propriété', 'description' => null],
            ['id' => 9, 'nom' => 'Attestation des bonnes conduites, vie et mœurs', 'description' => null],
        ]);
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('type_documents');
    }
};
