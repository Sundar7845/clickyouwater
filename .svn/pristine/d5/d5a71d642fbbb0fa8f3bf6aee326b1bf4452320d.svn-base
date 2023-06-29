<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropManIdHubId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('logistic_partners', function (Blueprint $table) {
            $table->dropForeign(['manufacturer_id']);
            $table->dropColumn('manufacturer_id');
            $table->dropForeign(['hub_id']);
            $table->dropColumn('hub_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('logistic_partners', function (Blueprint $table) {
            $table->unsignedBigInteger('manufacturer_id');
            $table->foreign('manufacturer_id')->references('id')->on('manufacturers');
            $table->unsignedBigInteger('hub_id');
            $table->foreign('hub_id')->references('id')->on('hubs');
        });
    }
}