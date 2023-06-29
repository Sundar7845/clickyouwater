<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterCustomerNearestHub extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('customer_nearest_hubs', function (Blueprint $table) {
            $table->dropForeign(['customer_id']);
            $table->dropColumn('customer_id');
            $table->unsignedBigInteger('customer_address_id')->after('id');
            $table->foreign('customer_address_id')->references('id')->on('customer_addresses');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('=customer_nearest_hubs', function (Blueprint $table) {
            $table->unsignedBigInteger('customer_id');
            $table->foreign('customer_id')->references('id')->on('customers');
            $table->dropForeign(['customer_address_id']);
            $table->dropColumn('customer_address_id');
        });
    }
}
