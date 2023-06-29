<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreatePaymentMethodConfigsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_method_configs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer_type_id')->nullable();
            $table->foreign('customer_type_id')->references('id')->on('customer_types')->onDelete('restrict')->onUpdate('cascade');
            $table->text('payment_method_id', 255)->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->foreign('created_by')->references('id')->on('users')->onDelete('restrict')->onUpdate('cascade');
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('restrict')->onUpdate('cascade');
            $table->timestamps();
        });
        DB::statement('ALTER TABLE payment_method_configs MODIFY payment_method_id TEXT');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payment_method_configs');
    }
}
