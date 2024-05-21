<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEstateContactDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('estate_contact_detail', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('contact_id');
            $table->longText('contact_message')->nullable();
            $table->integer('author');
            $table->integer('author_type')->default('0')->comment("0:client | 1:staff");
            $table->integer('response_type')->default('0')->comment("0:この内容で送信 | 1:登録のみ | 2:電話等で対応");
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('contact_id')->references('contact_id')->on('estate_contact');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('estate_contact_detail');
    }
}
