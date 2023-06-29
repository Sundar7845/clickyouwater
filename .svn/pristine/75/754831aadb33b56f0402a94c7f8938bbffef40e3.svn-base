<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schema;

class CreateMenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menus', function (Blueprint $table) {
            $table->id();
            $table->integer('parent_id')->nullable();
            $table->string('menu_name')->nullable();
            $table->integer('is_mainmenu')->default(0);
            $table->integer('is_module')->default(0);
            $table->integer('is_visible')->default(1);
            $table->string('group_name')->nullable();
            $table->string('menu_url')->nullable();
            $table->string('icon')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('menus');
    }
}
