<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogisticsManufactureConfigsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('logistics_manufacture_configs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('logistic_partner_id');
            $table->foreign('logistic_partner_id')->references('id')->on('logistic_partners');
            $table->unsignedBigInteger('manufacture_id');
            $table->foreign('manufacture_id')->references('id')->on('manufacturers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('logistics_manufacture_configs');
    }
}
