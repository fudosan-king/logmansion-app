<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEstateContactTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('estate_contact', function (Blueprint $table) {
            $table->increments('contact_id');
            $table->string('client_id');
            $table->foreign('client_id')->references('client_id')->on('estate_clients');
            $table->integer('contact_type')->default('0')->comment("0:その他 | 1:お問い合わせ | 2:アフターサービスのご相談");
            $table->integer('contact_spot')->nullable()->comment("0:その他 | 1:キッチン | 2:浴室 | 3:洗面 | 4:給排水 | 5:その他水回り | 6:壁・クロス | 7:床 | 8:建具");
            $table->integer('contact_status')->default('0')->comment("0:相談受付  | 1:回答待ち | 2:応答済 | 3:対応終了");
            $table->string('contact_title');
            $table->longText('contact_comment')->nullable();
            $table->integer('user_id')->nullable();
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
        Schema::dropIfExists('estate_contact');
    }
}
