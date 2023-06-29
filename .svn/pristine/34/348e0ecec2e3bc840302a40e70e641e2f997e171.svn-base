<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schema;

class CreateReasonTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reason_types', function (Blueprint $table) {
            $table->id();
            $table->string('reason_type')->nullable();
        });
        
        Artisan::call('db:seed', [
            '--class' => 'ReasonTypeSeeder'
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reason_types');
    }
}
