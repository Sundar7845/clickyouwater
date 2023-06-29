<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogisticsHubConfigsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('logistics_hub_configs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('logistic_partner_id');
            $table->foreign('logistic_partner_id')->references('id')->on('logistic_partners');
            $table->unsignedBigInteger('hub_id');
            $table->foreign('hub_id')->references('id')->on('hubs');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('logistics_hub_configs');
    }
}
