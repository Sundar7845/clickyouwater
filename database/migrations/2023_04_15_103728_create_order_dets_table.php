<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderDetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_dets', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id')->nullable();
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('restrict')->onUpdate('cascade');
            $table->unsignedBigInteger('product_id')->nullable();
            $table->foreign('product_id')->references('id')->on('products')->onDelete('restrict')->onUpdate('cascade');
            $table->integer('qty')->nullable();
            $table->float('price', 8, 2)->nullable();
            $table->float('deposit_amount', 8, 2)->nullable();
            $table->float('igst_amount', 8, 2)->nullable();
            $table->float('sgst_amount', 8, 2)->nullable();
            $table->float('cgst_amount', 8, 2)->nullable();
            $table->integer('return_empty_cans_qty')->default(0);
            $table->integer('collected_empty_cans_qty')->default(0);
            $table->integer('damaged_empty_cans_qty')->default(0);
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
        Schema::dropIfExists('order_dets');
    }
}
