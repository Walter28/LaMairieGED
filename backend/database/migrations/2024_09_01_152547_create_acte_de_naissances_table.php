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
        Schema::create('acte_de_naissances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('demande_id')->constrained()->onDelete('cascade');
            $table->string('kid_full_name');
            $table->date('kid_birth_date');
            $table->string('kid_birth_place');
            $table->string('kid_certificat_medical')->nullable();
            $table->string('dad_full_name');
            $table->string('dad_id_card');
            $table->string('mum_full_name');
            $table->string('mum_id_card');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('acte_de_naissances');
    }
};
