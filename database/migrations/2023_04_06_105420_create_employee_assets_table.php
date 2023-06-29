<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeeAssetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_assets', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('employee_id')->nullable();
            $table->foreign('employee_id')->references('id')->on('employees');
            $table->unsignedBigInteger('asset_type_id')->nullable();
            $table->foreign('asset_type_id')->references('id')->on('asset_types');
            $table->unsignedBigInteger('asset_id')->nullable();
            $table->foreign('asset_id')->references('id')->on('assets');
            $table->unsignedBigInteger('issued_by')->nullable();
            $table->foreign('issued_by')->references('id')->on('users');
            $table->unsignedBigInteger('authorised_by')->nullable();
            $table->foreign('authorised_by')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employee_assets');
    }
}
