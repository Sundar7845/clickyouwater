<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogisticStockHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('logistic_stock_histories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('driver_id');
            $table->foreign('driver_id')->references('id')->on('logistic_driver_infos');
            $table->unsignedBigInteger('product_type_id');
            $table->foreign('product_type_id')->references('id')->on('product_types');
            $table->unsignedBigInteger('brand_id');
            $table->foreign('brand_id')->references('id')->on('brands');
            $table->unsignedBigInteger('category_id');
            $table->foreign('category_id')->references('id')->on('categories');
            $table->unsignedBigInteger('product_id');
            $table->foreign('product_id')->references('id')->on('products');
            $table->integer('inward_from_hub_empty_qty')->default(0);
            $table->integer('outward_to_manufacture_qty')->default(0);
            $table->integer('outward_return_damaged_qty')->default(0);
            $table->integer('inward_from_manufacture_qty')->default(0);
            $table->integer('inward_return_manufacture_qty')->default(0);
            $table->integer('outward_to_hub_qty')->default(0);
            $table->integer('outward_return_filled_qty')->default(0);
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
        Schema::dropIfExists('logistic_stock_histories');
    }
}
