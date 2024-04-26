<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCatalogueTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('catalogue', function (Blueprint $table) {
            $table->increments('cata_id');
            $table->string('cata_title')->nullable();
            $table->string('cata_description')->nullable();
            $table->string('cata_image')->nullable();
            $table->string('cata_url')->nullable();
            $table->integer('cata_active')->default('0')->comment("有効 0:draft | 1:publish");
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
        Schema::dropIfExists('catalogue');
    }
}
