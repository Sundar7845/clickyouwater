<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCouponsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('coupon_type_id')->nullable();
            $table->foreign('coupon_type_id')->references('id')->on('coupon_types')->onDelete('restrict')->onUpdate('cascade');
            $table->string('coupon_name')->nullable();
            $table->string('coupon_code')->nullable();
            $table->dateTime('start_date')->nullable();
            $table->dateTime('end_date')->nullable();
            $table->integer('same_user_limit')->default(0);
            $table->unsignedBigInteger('discount_type_id')->nullable();
            $table->foreign('discount_type_id')->references('id')->on('discount_types')->onDelete('restrict')->onUpdate('cascade');
            $table->integer('discount_value')->nullable();
            $table->integer('max_discount')->nullable();
            $table->integer('min_order_qty')->nullable();
            $table->integer('is_active')->default(0);
            $table->unsignedBigInteger('created_by')->nullable();
            $table->foreign('created_by')->references('id')->on('users')->onDelete('restrict')->onUpdate('cascade');
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('restrict')->onUpdate('cascade');
            $table->unsignedBigInteger('deleted_by')->nullable();
            $table->foreign('deleted_by')->references('id')->on('users')->onDelete('restrict')->onUpdate('cascade');
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
        Schema::dropIfExists('coupons');
    }
}
