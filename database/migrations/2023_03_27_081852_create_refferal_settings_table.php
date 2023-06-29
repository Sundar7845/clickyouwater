<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRefferalSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('refferal_settings', function (Blueprint $table) {
            $table->id();
            $table->string('referral_content')->nullable();
            $table->integer('earnpoints_per_referral')->nullable();
            $table->integer('earnpoints_per_referrer')->nullable();
            $table->string('referral_banner_path')->nullable();
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
        Schema::dropIfExists('refferal_settings');
    }
}
