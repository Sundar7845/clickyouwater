<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_settings', function (Blueprint $table) {
            $table->id();
            $table->string('otp_length')->nullable();
            $table->string('otp_expiry_duration')->nullable();
            $table->integer('additional_delivery_charge')->default(0);
            $table->string('referral_code_length')->default(0);
            $table->boolean('is_maintenace_mode')->default(0);
            $table->string('company_name')->nullable();
            $table->longText('company_address')->nullable();
            $table->string('company_contactno')->nullable();
            $table->string('company_email')->nullable();
            $table->string('gstin')->nullable();
            $table->longText('privacy_policy_url')->nullable();
            $table->longText('terms_conditions_url')->nullable();
            $table->longText('cancellation_refund_url')->nullable();
            $table->longText('shipping_delivery_url')->nullable();
            $table->longText('play_store_url')->nullable();
            $table->longText('app_store_url')->nullable();
            $table->string('company_website')->nullable();
            $table->string('company_logo')->nullable();
            $table->string('app_logo')->nullable();
            $table->string('order_cancel_threshold_duration')->nullable();
            $table->integer('manufacture_order_delay')->nullable();
            $table->integer('show_orders_to_manufacturer')->nullable();
            $table->integer('notify_expire_days')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admin_settings');
    }
}
