<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeliveryVehicleInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('delivery_vehicle_infos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('hub_id');
            $table->foreign('hub_id')->references('id')->on('hubs');
            $table->unsignedBigInteger('delivery_people_id');
            $table->foreign('delivery_people_id')->references('id')->on('delivery_people');
            $table->unsignedBigInteger('hub_vehicle_info_id');
            $table->foreign('hub_vehicle_info_id')->references('id')->on('hub_vehicle_infos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('delivery_vehicle_infos');
    }
}
