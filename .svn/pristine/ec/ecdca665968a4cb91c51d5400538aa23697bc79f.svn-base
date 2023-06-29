<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStockOutwardDetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_outward_dets', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('stock_outward_id');
            $table->foreign('stock_outward_id')->references('id')->on('stock_outwards');
            $table->unsignedBigInteger('product_id');
            $table->foreign('product_id')->references('id')->on('products');
            $table->integer('qty')->default(0);
            $table->integer('return_qty')->default(0);
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
        Schema::dropIfExists('stock_outward_dets');
    }
}
