<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOfferCodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('offer_codes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('offer_id')->nullable();
            $table->foreign('offer_id')->references('id')->on('offers');
            $table->string('offer_code')->nullable();
            $table->string('offer_code_type')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->foreign('created_by')->references('id')->on('users');
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->foreign('updated_by')->references('id')->on('users');
            $table->unsignedBigInteger('deleted_by')->nullable();
            $table->foreign('deleted_by')->references('id')->on('users');
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
        Schema::dropIfExists('offer_codes');
    }
}
