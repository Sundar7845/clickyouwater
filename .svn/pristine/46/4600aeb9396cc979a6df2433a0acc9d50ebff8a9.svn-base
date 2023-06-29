<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLedgersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ledgers', function (Blueprint $table) {
            $table->id();
            $table->string('ledger_code')->nullable();
            $table->unsignedBigInteger('ledger_type_id');
            $table->foreign('ledger_type_id')->references('id')->on('ledger_types');
            $table->string('ledger_name')->nullable();
            $table->string('mobile')->nullable();
            $table->string('street')->nullable();
            $table->unsignedBigInteger('state_id');
            $table->foreign('state_id')->references('id')->on('states');
            $table->unsignedBigInteger('city_id');
            $table->foreign('city_id')->references('id')->on('cities');
            $table->unsignedBigInteger('area_id');
            $table->foreign('area_id')->references('id')->on('areas');
            $table->integer('pincode')->nullable();
            $table->string('credit_period')->nullable();
            $table->string('settlement_period')->nullable();
            $table->float('opening_balance', 8, 2)->nullable();
            $table->float('closing_balance', 8, 2)->nullable();
            $table->string('credit_debit')->nullable();
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
        Schema::dropIfExists('ledgers');
    }
}
