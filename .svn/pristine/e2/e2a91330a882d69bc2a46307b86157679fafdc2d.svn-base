<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropLogisiticVehicleId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('logistic_driver_infos', function (Blueprint $table) {
            $table->dropForeign(['logistic_vehicle_id']);
            $table->dropColumn('logistic_vehicle_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('logistic_driver_infos', function (Blueprint $table) {
            $table->unsignedBigInteger('logistic_vehicle_id')->nullable();
            $table->foreign('logistic_vehicle_id')->references('id')->on('logistic_partners')->onDelete('restrict')->onUpdate('cascade');
        });
    }
}
