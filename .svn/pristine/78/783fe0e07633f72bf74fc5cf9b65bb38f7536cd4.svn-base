<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomerAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_addresses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer_id');
            $table->foreign('customer_id')->references('id')->on('customers');
            $table->unsignedBigInteger('addresstype_id');
            $table->foreign('addresstype_id')->references('id')->on('address_types');
            $table->string('building_no')->nullable();
            $table->string('street')->nullable();
            $table->string('area')->nullable();
            $table->string('landmark')->nullable();
            $table->unsignedBigInteger('city_id');
            $table->foreign('city_id')->references('id')->on('cities');
            $table->unsignedBigInteger('state_id');
            $table->foreign('state_id')->references('id')->on('states');
            $table->unsignedBigInteger('country_id');
            $table->foreign('country_id')->references('id')->on('countries');
            $table->integer('pincode')->nullable();
            $table->string('floor')->nullable();
            $table->integer('is_lift_avail_working')->nullable();
            $table->string('contact_person_name')->nullable();
            $table->string('contact_person_mobile')->nullable();
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->string('geolocation')->nullable();
            $table->integer('is_service_available')->default(0);
            $table->integer('is_default')->default(0);
            $table->integer('is_manual_address')->default(0);
            $table->unsignedBigInteger('created_by')->nullable();
            $table->foreign('created_by')->references('id')->on('users');
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->foreign('updated_by')->references('id')->on('users');
            $table->unsignedBigInteger('deleted_by')->nullable();
            $table->foreign('deleted_by')->references('id')->on('users');
            $table->softDeletes();
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
        Schema::dropIfExists('customer_addresses');
    }
}
