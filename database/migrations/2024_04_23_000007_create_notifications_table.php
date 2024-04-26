<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->increments('noti_id');
            $table->integer('cat_id')->nullable();
            $table->string('noti_title')->nullable();
            $table->string('noti_content')->nullable()->comment("本文");
            $table->timestamp('noti_date')->nullable()->comment("日付");
            $table->integer('noti_status')->default('0')->comment("有効 0:draft | 1:publish");
            $table->string('noti_url')->nullable();
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
        Schema::dropIfExists('notifications');
    }
}
