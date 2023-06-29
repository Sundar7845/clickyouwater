<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateManufactureStockHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('manufacture_stock_histories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('manufacture_id');
            $table->foreign('manufacture_id')->references('id')->on('manufacturers');
            $table->unsignedBigInteger('product_type_id');
            $table->foreign('product_type_id')->references('id')->on('product_types');
            $table->unsignedBigInteger('brand_id');
            $table->foreign('brand_id')->references('id')->on('brands');
            $table->unsignedBigInteger('category_id');
            $table->foreign('category_id')->references('id')->on('categories');
            $table->unsignedBigInteger('product_id');
            $table->foreign('product_id')->references('id')->on('products');
            $table->integer('mf_inward_qty')->default(0);
            $table->integer('mf_inward_return_qty')->default(0);
            $table->integer('mf_logistic_inward_qty')->default(0);
            $table->integer('mf_damage_qty')->default(0);
            $table->integer('mf_filling_outward_qty')->default(0);
            $table->integer('mf_filling_outward_return_qty')->default(0);
            $table->integer('mf_production_inward_qty')->default(0);
            $table->integer('mf_logistic_outward_qty')->default(0);
            $table->integer('mf_logistic_return_qty')->default(0);
            $table->integer('mf_otheritems_inward_qty')->default(0);
            $table->integer('mf_otheritems_removed_qty')->default(0);
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
        Schema::dropIfExists('manufacture_stock_histories');
    }
}
