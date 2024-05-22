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
        Schema::dropIfExists('estate_contact_attach');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::create('estate_contact_attach', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('contact_id');
            $table->string('contact_file')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('contact_id')->references('contact_id')->on('estate_contact');
        });
    }
};
