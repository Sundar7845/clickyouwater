<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_no')->nullable();
            $table->string('invoice_no')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('restrict')->onUpdate('cascade');
            $table->unsignedBigInteger('hub_id')->nullable();
            $table->foreign('hub_id')->references('id')->on('hubs')->onDelete('restrict')->onUpdate('cascade');
            $table->unsignedBigInteger('delivery_address_id')->nullable();
            $table->foreign('delivery_address_id')->references('id')->on('customer_addresses')->onDelete('restrict')->onUpdate('cascade');
            $table->longText('delivery_address')->nullable();
            $table->float('delivery_charge', 8, 2)->default(0);
            $table->dateTime('exp_delivery_date')->nullable();
            $table->unsignedBigInteger('coupon_id')->nullable();
            $table->string('coupon_code')->nullable();
            $table->string('coupon_code_type')->nullable();
            $table->integer('coupon_points')->default(0);
            $table->float('total_discount_amount', 8, 2)->default(0);
            $table->float('total_igst_amount', 8, 2)->default(0);
            $table->float('total_sgst_amount', 8, 2)->default(0);
            $table->float('total_cgst_amount', 8, 2)->default(0);
            $table->integer('total_qty')->default(0);
            $table->integer('total_return_qty')->default(0);
            $table->integer('wallet_points_used')->default(0);
            $table->float('deposit_amount', 8, 2)->default(0);
            $table->float('total_tax_amount', 8, 2)->default(0);
            $table->float('sub_total', 8, 2)->default(0);
            $table->float('taxable_amount', 8, 2)->default(0);
            $table->float('roundoff', 8, 2)->default(0);
            $table->float('grand_total', 8, 2)->default(0);
            $table->string('desc')->nullable();
            $table->unsignedBigInteger('status_id')->nullable();
            $table->foreign('status_id')->references('id')->on('statuses')->onDelete('restrict')->onUpdate('cascade');
            $table->boolean('is_cancel')->default(0);
            $table->float('transaction_amount', 8, 2)->default(0);
            $table->dateTime('transaction_date')->nullable();
            $table->string('transaction_status')->nullable();
            $table->string('transaction_response')->nullable();
            $table->string('transaction_id')->nullable();
            $table->string('transaction_order_id')->nullable();
            $table->string('payment_method')->nullable();
            $table->string('payment_through')->nullable();
            $table->string('invoice_path')->nullable();
            $table->integer('is_invoice_downloaded')->default(0);
            $table->integer('delivery_status_id')->nullable();
            $table->integer('is_refund')->default(0);
            $table->integer('is_admin_order')->default(0);
            $table->boolean('is_manufacture_received')->default(0);
            $table->float('additional_delivery_charge', 8, 2)->default(0);
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
        Schema::dropIfExists('orders');
    }
}
