<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddGeoCoordinates extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('hubs', function (Blueprint $table) {
            $table->polygon('geo_coordinates')->nullable()->after('geo_location');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('hubs', function (Blueprint $table) {
            $table->dropColumn('geo_coordinates');
        });
    }
}
