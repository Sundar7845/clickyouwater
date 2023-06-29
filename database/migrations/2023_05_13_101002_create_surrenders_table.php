<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSurrendersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('surrenders', function (Blueprint $table) {
            $table->id();
            $table->string('surrender_order_no')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->unsignedBigInteger('reason_id');
            $table->foreign('reason_id')->references('id')->on('reasons');
            $table->unsignedBigInteger('hub_id');
            $table->foreign('hub_id')->references('id')->on('hubs');
            $table->integer('total_qty')->default(0);
            $table->unsignedBigInteger('status_id');
            $table->foreign('status_id')->references('id')->on('statuses');
            $table->unsignedBigInteger('address_id');
            $table->longText('pickup_address')->nullable();
            $table->foreign('address_id')->references('id')->on('customer_addresses');
            $table->float('refund_amount', 8, 2)->default(0);
            $table->string('refund_to')->nullable();
            $table->integer('is_refund_processed')->default(0);
            $table->longText('reject_reason_note')->nullable();
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
        Schema::dropIfExists('surrenders');
    }
}
