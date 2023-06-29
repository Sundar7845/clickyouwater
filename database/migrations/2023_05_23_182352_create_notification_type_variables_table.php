<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificationTypeVariablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notification_type_variables', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('notification_type_id');
            $table->foreign('notification_type_id')->references('id')->on('notification_types');
            $table->longText('variables')->nullable();
            $table->longText('replace_column')->nullable();
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
        Schema::dropIfExists('notification_type_variables');
    }
}
