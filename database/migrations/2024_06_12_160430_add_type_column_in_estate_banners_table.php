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
            $table->integer('banner_type')->after('banner_id')->default('0')->comment("0:image | 1:image & text");
        });

        Schema::table('faq', function (Blueprint $table) {
            $table->integer('faq_type')->after('faq_id')->default('0')->comment("0:お住まいに関すること | 1:アプリに関すること");
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
            $table->dropColumn('banner_type');
        });

        Schema::table('faq', function (Blueprint $table) {
            $table->dropColumn('faq_type');
        });
    }
};
