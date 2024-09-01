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
        Schema::create('acte_de_mariages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('demande_id')->constrained()->onDelete('cascade');
            $table->string('husband_full_name');
            $table->string('husband_id_card');
            $table->string('husband_certificat_naiss')->nullable();
            $table->string('marry_full_name');
            $table->string('marry_id_card');
            $table->string('marry_certificat_naiss')->nullable();
            $table->string('wedding_place');
            $table->string('couple_leaving_proof')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('acte_de_mariages');
    }
};
