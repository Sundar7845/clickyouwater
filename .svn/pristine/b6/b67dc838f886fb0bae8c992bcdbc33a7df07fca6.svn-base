<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCategoryId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('brands', function (Blueprint $table) {
            $table->unsignedBigInteger('category_id')->after('id');
            $table->foreign('category_id')->references('id')->on('categories');
            $table->unsignedBigInteger('product_type_id')->after('category_id');
            $table->foreign('product_type_id')->references('id')->on('product_types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('brands', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
            $table->dropColumn('category_id');
            $table->dropForeign(['product_type_id']);
            $table->dropColumn('product_type_id');
        });
    }
}
