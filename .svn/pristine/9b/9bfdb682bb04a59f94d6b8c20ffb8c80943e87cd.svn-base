<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHubVehicleInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hub_vehicle_infos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('hub_id')->nullable();
            $table->foreign('hub_id')->references('id')->on('hubs');
            $table->unsignedBigInteger('fuel_type_id')->nullable();
            $table->foreign('fuel_type_id')->references('id')->on('fuel_types');
            $table->unsignedBigInteger('vehicle_type_id')->nullable();
            $table->foreign('vehicle_type_id')->references('id')->on('vehicle_types');
            $table->unsignedBigInteger('vehicle_brand_id')->nullable();
            $table->foreign('vehicle_brand_id')->references('id')->on('vehicle_brands');
            $table->string('reg_no')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hub_vehicle_infos');
    }
}
