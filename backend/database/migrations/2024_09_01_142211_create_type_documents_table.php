<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

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
            $table->text('page_name')->nullable();
            $table->timestamps();
        });

        // Ajout des entrées par défaut
        DB::table('type_documents')->insert([
            ['id' => 1, 'nom' => 'Acte de naissance', 'description' => null, 'page_name' => 'acte-naiss-preview'],
            ['id' => 2, 'nom' => 'Acte de mariage', 'description' => null, 'page_name' => 'acte-de-mariage-preview'],
            ['id' => 3, 'nom' => 'Certificat de décès', 'description' => null, 'page_name' => 'cert-de-dece-preview'],
            ['id' => 4, 'nom' => 'Certificat de résidence', 'description' => null, 'page_name' => 'cert-de-residence-preview'],
            ['id' => 5, 'nom' => 'Carte d\'identité nationale', 'description' => null, 'page_name' => 'carte-id-national-preview'],
            ['id' => 6, 'nom' => 'Certificat de célibat', 'description' => null, 'page_name' => 'cert-de-celibat-preview'],
            ['id' => 7, 'nom' => 'Permis de conduire', 'description' => null, 'page_name' => 'permis-de-cond-preview'],
            ['id' => 8, 'nom' => 'Attestation de propriété', 'description' => null, 'page_name' => 'attest-de-propriete-preview'],
            ['id' => 9, 'nom' => 'Attestation des bonnes conduites, vie et mœurs', 'description' => null, 'page_name' => 'attest-de-bonnes-cond-vie-moeurs-preview'],
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
