<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogisticStocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('logistic_stocks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('driver_id');
            $table->foreign('driver_id')->references('id')->on('logistic_driver_infos');
            $table->unsignedBigInteger('product_id');
            $table->foreign('product_id')->references('id')->on('products');
            $table->integer('order_qty')->default(0);
            $table->integer('filled_qty')->default(0);
            $table->integer('empty_qty')->default(0);
            $table->integer('damaged_qty')->default(0);
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
        Schema::dropIfExists('logistic_stocks');
    }
}
