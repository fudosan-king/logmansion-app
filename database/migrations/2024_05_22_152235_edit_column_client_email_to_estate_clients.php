<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


class EditColumnClientEmailToEstateClients extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('estate_clients', function (Blueprint $table) {
            $table->string('client_email')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('estate_clients', function (Blueprint $table) {
            $table->dropColumn('client_email')->nullable(false)->change();
        });
    }
};
