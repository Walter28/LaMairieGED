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
        Schema::table('type_documents', function (Blueprint $table) {
            $table->text('page_name')->nullable();
        });

        DB::table('type_documents')->where('id', 1)->update(['page_name' => 'acte-naiss-preview']);
        DB::table('type_documents')->where('id', 2)->update(['page_name' => 'acte-de-mariage-preview']);
        DB::table('type_documents')->where('id', 3)->update(['page_name' => 'cert-de-dece-preview']);
        DB::table('type_documents')->where('id', 4)->update(['page_name' => 'cert-de-residence-preview']);
        DB::table('type_documents')->where('id', 5)->update(['page_name' => 'carte-id-national-preview']);
        DB::table('type_documents')->where('id', 6)->update(['page_name' => 'cert-de-celibat-preview']);
        DB::table('type_documents')->where('id', 7)->update(['page_name' => 'permis-de-cond-preview']);
        DB::table('type_documents')->where('id', 8)->update(['page_name' => 'attest-de-propriete-preview']);
        DB::table('type_documents')->where('id', 9)->update(['page_name' => 'attest-de-bonnes-cond-vie-moeurs-preview']);
    }

};
