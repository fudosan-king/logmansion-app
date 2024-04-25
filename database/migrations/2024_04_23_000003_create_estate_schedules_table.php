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
            $table->string('schedule_id', 20)->unique();
            $table->integer('est_id')->nullable();
            $table->string('schedule_name')->nullable();
            $table->timestamp('schedule_date')->nullable();
            $table->integer('schedule_show')->default('1')->comment("0:not show | 1:show");
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
