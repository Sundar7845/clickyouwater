<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStockOutwardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_outwards', function (Blueprint $table) {
            $table->id();
            $table->string('outward_no')->nullable();
            $table->unsignedBigInteger('manufacture_id');
            $table->foreign('manufacture_id')->references('id')->on('manufacturers');
            $table->dateTime('accepted_on')->nullable();
            $table->unsignedBigInteger('created_by');
            $table->foreign('created_by')->references('id')->on('users');
            $table->unsignedBigInteger('updated_by');
            $table->foreign('updated_by')->references('id')->on('users');
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
        Schema::dropIfExists('stock_outwards');
    }
}
