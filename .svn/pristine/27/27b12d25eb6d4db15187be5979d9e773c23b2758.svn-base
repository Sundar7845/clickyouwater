<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_notifications', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('restrict')->onUpdate('cascade');
            $table->longText('notification_msg')->nullable();
            $table->unsignedBigInteger('notification_type_id')->nullable();
            $table->foreign('notification_type_id')->references('id')->on('notification_types')->onDelete('restrict')->onUpdate('cascade');
            $table->dateTime('notified_on')->nullable();
            $table->boolean('is_viewed')->default(0);
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
        Schema::dropIfExists('user_notifications');
    }
}
