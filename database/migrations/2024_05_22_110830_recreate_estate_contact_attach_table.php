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
        Schema::create('estate_contact_attach', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('contact_detail_id');
            $table->string('path_file')->nullable(false);
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('contact_detail_id')->references('id')->on('estate_contact_detail');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('estate_contact_attach');
    }
};
