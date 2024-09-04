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
        Schema::create('chats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_from_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('user_to_id')->constrained('users')->onDelete('cascade');
            $table->text('message');
            $table->string('status')->default('unread');
            $table->timestamps(); // This will add 'created_at' and 'updated_at'
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chats');
    }
};
