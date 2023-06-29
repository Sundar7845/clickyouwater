<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderDeliveriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_deliveries', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id');
            $table->foreign('order_id')->references('id')->on('orders');
            $table->unsignedBigInteger('delivery_user_id');
            $table->foreign('delivery_user_id')->references('id')->on('users');
            $table->string('floor')->nullable();
            $table->integer('is_lift')->nullable();
            $table->longText('delivery_user_notes')->nullable();
            $table->longText('delivery_reason')->nullable();
            $table->integer('customer_rating')->default(0);
            $table->integer('is_highlighted')->default(0);
            $table->integer('is_notdelivered')->default(0);
            $table->timestamp('delivered_on')->nullable();
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
        Schema::dropIfExists('order_deliveries');
    }
}
