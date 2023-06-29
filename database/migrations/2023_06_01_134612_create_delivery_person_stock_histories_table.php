<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeliveryPersonStockHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('delivery_person_stock_histories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('hub_id');
            $table->foreign('hub_id')->references('id')->on('hubs');
            $table->unsignedBigInteger('delivery_user_id');
            $table->foreign('delivery_user_id')->references('id')->on('users');
            $table->unsignedBigInteger('category_id');
            $table->foreign('category_id')->references('id')->on('categories');
            $table->unsignedBigInteger('product_type_id');
            $table->foreign('product_type_id')->references('id')->on('product_types');
            $table->unsignedBigInteger('brand_id');
            $table->foreign('brand_id')->references('id')->on('brands');
            $table->unsignedBigInteger('product_id');
            $table->foreign('product_id')->references('id')->on('products');
            $table->integer('inward_from_customer_qty')->default(0);
            $table->integer('outward_to_hub_qty')->default(0);
            $table->integer('inward_from_hub_qty')->default(0);
            $table->integer('inward_return_qty')->default(0);
            $table->integer('outward_to_customer_qty')->default(0);
            $table->integer('outward_return_qty')->default(0);
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
        Schema::dropIfExists('delivery_person_stock_histories');
    }
}
