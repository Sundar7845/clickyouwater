<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogisticTripsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('logistic_trips', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('manufacture_id');
            $table->foreign('manufacture_id')->references('id')->on('manufacturers');
            $table->unsignedBigInteger('driver_id');
            $table->foreign('driver_id')->references('id')->on('logistic_driver_infos');
            $table->integer('is_active')->default(1);
            $table->dateTime('trip_start_on')->nullable();
            $table->dateTime('trip_end_on')->nullable();
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
        Schema::dropIfExists('logistic_trips');
    }
}
