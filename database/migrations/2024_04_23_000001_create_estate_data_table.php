<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEstateDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('estate_data', function (Blueprint $table) {
            $table->increments('est_id');
            $table->string('est_room_no')->nullable();
            $table->string('est_name')->nullable();
            $table->string('est_zip')->nullable();
            $table->string('est_pref')->nullable();
            $table->string('est_city')->nullable();
            $table->string('est_ward')->nullable();
            $table->string('est_address')->nullable();
            $table->integer('est_archive')->default('0')->comment("0:unarchive | 1:archive");
            $table->string('est_usefulinfo_pref_url')->nullable();
            $table->integer('est_usefulinfo_pref_show')->default('0')->comment("0:not show | 1:show");
            $table->string('est_usefulinfo_city_url')->nullable();
            $table->integer('est_usefulinfo_city_show')->default('0')->comment("0:not show | 1:show");
            $table->string('est_usefulinfo_ward_url')->nullable();
            $table->integer('est_usefulinfo_ward_show')->default('0')->comment("0:not show | 1:show");
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('estate_data');
    }
}
