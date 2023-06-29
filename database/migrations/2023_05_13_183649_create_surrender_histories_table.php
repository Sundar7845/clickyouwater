<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSurrenderHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('surrender_histories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('surrender_id');
            $table->foreign('surrender_id')->references('id')->on('surrenders');
            $table->unsignedBigInteger('status_id');
            $table->foreign('status_id')->references('id')->on('statuses');
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
        Schema::dropIfExists('surrender_histories');
    }
}
