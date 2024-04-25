<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBannersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('estate_banners', function (Blueprint $table) {
            $table->increments('banner_id');
            $table->string('banner_description')->nullable();
            $table->string('banner_image')->nullable();
            $table->string('banner_url')->nullable();
            $table->integer('banner_active')->default('0')->comment("0:deactive | 1:active");
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
        Schema::dropIfExists('estate_banners');
    }
}
