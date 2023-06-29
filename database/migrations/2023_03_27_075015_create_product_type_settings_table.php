<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductTypeSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_type_settings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_type_id');
            $table->foreign('product_type_id')->references('id')->on('product_types');
            $table->integer('manufacture_price')->nullable();
            $table->integer('hub_price')->nullable();
            $table->integer('logistics_price')->nullable();
            $table->integer('before_ship_mins_alert')->nullable();
            $table->integer('after_ship_mins_alert')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_type_settings');
    }
}
