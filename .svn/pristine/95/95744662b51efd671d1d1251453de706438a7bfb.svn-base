<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSurrenderDetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('surrender_dets', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('surrender_id');
            $table->foreign('surrender_id')->references('id')->on('surrenders');
            $table->integer('qty')->default(0);
            $table->unsignedBigInteger('product_id');
            $table->foreign('product_id')->references('id')->on('products');
            $table->float('deposit_amount', 8, 2)->default(0);
            $table->integer('collected_can_qty')->default(0);
            $table->integer('damaged_can_qty')->default(0);
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
        Schema::dropIfExists('surrender_dets');
    }
}
