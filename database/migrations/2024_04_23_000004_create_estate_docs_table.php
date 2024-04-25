<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEstateDocsTable extends Migration
{ 
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('estate_docs', function (Blueprint $table) {
            $table->integer('doc_id')->unique();
            $table->integer('est_id')->nullable();
            $table->integer('doc_category')->default('0')->comment(" 0:押印済み書類 | 1:管理系資料 | 2:付属資料");
            $table->string('doc_name')->nullable();
            $table->string('doc_file')->nullable();
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
        Schema::dropIfExists('estate_docs');
    }
}
