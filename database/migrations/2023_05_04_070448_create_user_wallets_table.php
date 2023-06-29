<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserWalletsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_wallets', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('restrict')->onUpdate('cascade');
            $table->float('amount', 8, 2)->nullable();
            $table->float('balance', 8, 2)->nullable();
            $table->boolean('credit_debit')->default(0);
            $table->unsignedBigInteger('wallet_transaction_type_id')->nullable();
            $table->foreign('wallet_transaction_type_id')->references('id')->on('wallet_transaction_types')->onDelete('restrict')->onUpdate('cascade');
            $table->dateTime('transaction_date')->nullable();
            $table->string('transaction_status')->nullable();
            $table->string('transaction_response')->nullable();
            $table->string('transaction_id')->nullable();
            $table->string('transaction_order_id')->nullable();
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
        Schema::dropIfExists('user_wallets');
    }
}