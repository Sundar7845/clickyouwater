<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHubReturnItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hub_return_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('hub_id');
            $table->foreign('hub_id')->references('id')->on('hubs');
            $table->unsignedBigInteger('driver_id');
            $table->foreign('driver_id')->references('id')->on('logistic_driver_infos');
            $table->unsignedBigInteger('status_id');
            $table->foreign('status_id')->references('id')->on('statuses');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hub_return_items');
    }
}
