<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHubsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hubs', function (Blueprint $table) {
            $table->id();
            $table->string('hub_code');
            $table->string('hub_name');
            $table->unsignedBigInteger('manufacturer_id');
            $table->foreign('manufacturer_id')->references('id')->on('manufacturers');
            $table->string('years_of_experience')->nullable();
            $table->string('mobile')->nullable();
            $table->string('official_email')->nullable();
            $table->string('latitude')->nullable();
            $table->string('longtitude')->nullable();
            $table->string('geo_location')->nullable();
            $table->string('max_delivery_distance')->nullable();
            $table->longText('geo_coordinates')->nullable();
            $table->string('credit_period')->nullable();
            $table->string('settlement_period')->nullable();
            $table->longtext('security_deposit')->nullable();
            $table->string('password')->nullable();
            $table->unsignedBigInteger('state_id');
            $table->foreign('state_id')->references('id')->on('states');
            $table->unsignedBigInteger('city_id');
            $table->foreign('city_id')->references('id')->on('cities');
            $table->unsignedBigInteger('area_id');
            $table->foreign('area_id')->references('id')->on('areas');
            $table->string('address')->nullable();
            $table->string('pincode')->nullable();
            $table->string('proprietor_name')->nullable();
            $table->string('proprietor_mobile')->nullable();
            $table->string('proprietor_email')->nullable();
            $table->string('contact_person_name')->nullable();
            $table->string('contact_person_mobile')->nullable();
            $table->string('contact_person_email')->nullable();
            $table->string('qr_code_image')->nullable();
            $table->integer('is_active')->default(0);
            $table->unsignedBigInteger('created_by')->nullable();
            $table->foreign('created_by')->references('id')->on('users');
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->foreign('updated_by')->references('id')->on('users');
            $table->unsignedBigInteger('deleted_by')->nullable();
            $table->foreign('deleted_by')->references('id')->on('users');
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
        Schema::dropIfExists('hubs');
    }
}
