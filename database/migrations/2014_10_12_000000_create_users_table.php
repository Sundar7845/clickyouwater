<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique()->nullable();
            $table->string('user_img_path')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('OTP');
            $table->timestamp('otp_expiry')->nullable();
            $table->string('referral_code')->nullable();
            $table->string('device_id')->nullable();
            $table->string('fcm_token')->nullable();
            $table->integer('wallet_points')->default(0);
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
