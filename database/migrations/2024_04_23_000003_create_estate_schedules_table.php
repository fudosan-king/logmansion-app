<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEstateSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('estate_schedules', function (Blueprint $table) {
            $table->increments('schedule_id');
            $table->integer('est_id')->nullable();
            $table->string('schedule_name')->nullable();
            $table->longText('schedule_description')->nullable();
            $table->date('schedule_date')->nullable();
            $table->integer('schedule_active')->default('1')->comment("0:not active | 1:active");
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
        Schema::dropIfExists('estate_schedules');
    }
}
