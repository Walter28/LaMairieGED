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
    public function up(): void
    {
        Schema::table('type_documents', function (Blueprint $table) {
            //
        });
        DB::table('type_documents')->where('id', 7)->update(['nom' => 'Permis de construire']);
        DB::table('type_documents')->where('id', 7)->update(['page_name' => 'permis-de-construire-preview']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('type_documents', function (Blueprint $table) {
            //
        });
    }
};
