<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLogisiticVehicleId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('logistic_driver_infos', function (Blueprint $table) {
            $table->unsignedBigInteger('logistic_vehicle_id')->after('logistic_partner_id');
            $table->foreign('logistic_vehicle_id')->references('id')->on('logistic_vehicle_infos')->onDelete('restrict')->onUpdate('cascade');
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
            $table->dropForeign(['logistic_vehicle_id']);
            $table->dropColumn('logistic_vehicle_id');
        });
    }
}
