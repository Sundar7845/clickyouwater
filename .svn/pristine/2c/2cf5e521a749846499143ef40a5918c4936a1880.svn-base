<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRadius extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('areas', function (Blueprint $table) {
            $table->integer('radius')->default(0)->after('state_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('areas', function (Blueprint $table) {
            $table->dropColumn('radius')->default(0);
        });
    }
}
