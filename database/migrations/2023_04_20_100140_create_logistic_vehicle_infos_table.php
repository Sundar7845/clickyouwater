<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogisticVehicleInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('logistic_vehicle_infos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('logistic_partner_id')->nullable();
            $table->foreign('logistic_partner_id')->references('id')->on('logistic_partners')->onDelete('restrict')->onUpdate('cascade');
            $table->unsignedBigInteger('fuel_type_id')->nullable();
            $table->foreign('fuel_type_id')->references('id')->on('fuel_types')->onDelete('restrict')->onUpdate('cascade');
            $table->unsignedBigInteger('vehicle_brand_id')->nullable();
            $table->foreign('vehicle_brand_id')->references('id')->on('vehicle_brands')->onDelete('restrict')->onUpdate('cascade');
            $table->unsignedBigInteger('vehicle_type_id')->nullable();
            $table->foreign('vehicle_type_id')->references('id')->on('vehicle_types')->onDelete('restrict')->onUpdate('cascade');
            $table->string('reg_no')->nullable();
            $table->integer('capacity')->default(0);
            $table->integer('weight')->default(0);
            $table->unsignedBigInteger('created_by')->nullable();
            $table->foreign('created_by')->references('id')->on('users')->onDelete('restrict')->onUpdate('cascade');
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('restrict')->onUpdate('cascade');
            $table->unsignedBigInteger('deleted_by')->nullable();
            $table->foreign('deleted_by')->references('id')->on('users')->onDelete('restrict')->onUpdate('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('logistic_vehicle_infos');
    }
}
