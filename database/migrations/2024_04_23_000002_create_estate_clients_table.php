<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEstateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('estate_clients', function (Blueprint $table) {
            $table->string('client_id', 20)->unique();
            $table->integer('est_id')->nullable();
            $table->string('client_name')->nullable();
            $table->string('client_f_name')->nullable();
            $table->string('client_l_name')->nullable();
            $table->string('client_furigana')->nullable();
            $table->string('client_email', 255)->unique();
            $table->string('client_password', 255)->nullable();
            $table->string('client_tel')->nullable();
            // $table->string('cli_address')->nullable();
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
        Schema::dropIfExists('estate_clients');
    }
}
