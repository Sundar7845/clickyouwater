<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogisticBookingDetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('logistic_booking_dets', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('logistic_booking_id');
            $table->foreign('logistic_booking_id')->references('id')->on('logistic_bookings');
            $table->unsignedBigInteger('hub_id');
            $table->foreign('hub_id')->references('id')->on('hubs');
            $table->unsignedBigInteger('product_id');
            $table->foreign('product_id')->references('id')->on('products');
            $table->integer('qty')->default(0);
            $table->integer('received_qty')->default(0);
            $table->integer('return_damaged_qty')->default(0);
            $table->integer('is_hub_confirmed')->default(0);
            $table->dateTime('delivered_on')->nullable();
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
        Schema::dropIfExists('logistic_booking_dets');
    }
}
