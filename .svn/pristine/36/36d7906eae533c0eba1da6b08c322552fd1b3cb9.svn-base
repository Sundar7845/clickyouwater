<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeliveryPersonStocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('delivery_person_stocks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('hub_id');
            $table->foreign('hub_id')->references('id')->on('hubs');
            $table->unsignedBigInteger('delivery_user_id');
            $table->foreign('delivery_user_id')->references('id')->on('users');
            $table->unsignedBigInteger('product_id');
            $table->foreign('product_id')->references('id')->on('products');
            $table->integer('qty')->default(0);
            $table->integer('extra_qty')->default(0);
            $table->integer('return_empty_qty')->default(0);
            $table->integer('collected_empty_qty')->default(0);
            $table->integer('return_damaged_qty')->default(0);
            $table->integer('lost_qty')->default(0);
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
        Schema::dropIfExists('delivery_person_stocks');
    }
}
