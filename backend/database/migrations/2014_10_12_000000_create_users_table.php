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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('full_name');
            $table->string('email')->unique(); // Ajouter l'email avec contrainte unique
            $table->date('birth_date');
            $table->string('birth_place');
            $table->string('address');
            $table->string('nationality');
            $table->string('sexe');
            $table->string('role');
            $table->string('profile_pic')->nullable();
            $table->string('identity_card')->nullable();
            $table->string('password');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
