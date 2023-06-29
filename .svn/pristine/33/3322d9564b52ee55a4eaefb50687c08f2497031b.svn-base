<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->date('payment_date')->nullable();
            $table->string('payment_code')->nullable();
            $table->unsignedBigInteger('ledger_id')->nullable();
            $table->foreign('ledger_id')->references('id')->on('ledgers');
            $table->unsignedBigInteger('company_ledger_id')->nullable();
            $table->foreign('company_ledger_id')->references('id')->on('ledgers');
            $table->unsignedBigInteger('employee_user_id')->nullable();
            $table->foreign('employee_user_id')->references('id')->on('users');
            $table->unsignedBigInteger('payment_type_id')->nullable();
            $table->foreign('payment_type_id')->references('id')->on('payment_types');
            $table->unsignedBigInteger('payment_mode_id')->nullable();
            $table->foreign('payment_mode_id')->references('id')->on('payment_modes');
            $table->float('amount_paid', 8, 2)->nullable();
            $table->longText('notes')->nullable();
            $table->unsignedBigInteger('bank_id')->nullable();
            $table->foreign('bank_id')->references('id')->on('banks');
            $table->string('branch_name')->nullable();
            $table->date('transaction_date')->nullable();
            $table->string('transaction_number')->nullable();
            $table->integer('is_cancelled')->default(0);
            $table->unsignedBigInteger('created_by')->nullable();
            $table->foreign('created_by')->references('id')->on('users');
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->foreign('updated_by')->references('id')->on('users');
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
        Schema::dropIfExists('payments');
    }
}
