<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExpensesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->date('expense_date')->nullable();
            $table->unsignedBigInteger('expensegroup_id')->nullable();
            $table->foreign('expensegroup_id')->references('id')->on('expense_groups');
            $table->unsignedBigInteger('expense_type_id')->nullable();
            $table->foreign('expense_type_id')->references('id')->on('expense_types');
            $table->unsignedBigInteger('ledger_id')->nullable();
            $table->foreign('ledger_id')->references('id')->on('ledgers');
            $table->unsignedBigInteger('company_ledger_id')->nullable();
            $table->foreign('company_ledger_id')->references('id')->on('ledgers');
            $table->unsignedBigInteger('employee_user_id')->nullable();
            $table->foreign('employee_user_id')->references('id')->on('users');
            $table->float('amount', 8, 2)->nullable();
            $table->boolean('is_paid')->default(0);
            $table->float('amount_paid', 8, 2)->nullable();
            $table->string('expense_proof_path')->nullable();
            $table->string('notes')->nullable();
            $table->boolean('is_cancelled')->default(0);
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
        Schema::dropIfExists('expenses');
    }
}
