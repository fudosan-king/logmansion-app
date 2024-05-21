<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
     public function up()
    {
        Schema::table('estate_clients', function (Blueprint $table) {
            $table->bigIncrements('id')->after('client_id');
            $table->string('client_furigana_firstname')->nullable()->after('client_furigana');
            $table->string('client_furigana_lastname')->nullable()->after('client_furigana_firstname');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('estate_clients', function (Blueprint $table) {
            $table->dropColumn('id');
            $table->dropColumn('client_furigana_firstname');
            $table->dropColumn('client_furigana_lastname');
        });
    }
};
