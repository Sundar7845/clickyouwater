<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentDetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_dets', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('payment_id')->default(0);
            $table->foreign('payment_id')->references('id')->on('payments');
            $table->unsignedBigInteger('expense_id')->default(0);
            $table->foreign('expense_id')->references('id')->on('expenses');
            $table->integer('amount')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payment_dets');
    }
}
