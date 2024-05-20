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
        Schema::table('estate_contact_detail', function (Blueprint $table) {
            $table->longText('contact_note')->after('author_type')->nullable();
            $table->dropColumn('response_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('estate_contact_detail', function (Blueprint $table) {
            $table->int('response_type')->nullable(false);
            $table->dropColumn('contact_note');
        });
    }
};
