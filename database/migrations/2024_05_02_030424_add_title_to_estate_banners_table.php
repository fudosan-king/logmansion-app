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
        Schema::table('estate_banners', function (Blueprint $table) {
            $table->string('banner_title')->nullable()->after('banner_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('estate_banners', function (Blueprint $table) {
            $table->dropColumn('banner_title');
        });
    }
};
