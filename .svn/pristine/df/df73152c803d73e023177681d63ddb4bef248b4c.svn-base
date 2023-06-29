<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schema;

class CreateLedgerTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ledger_types', function (Blueprint $table) {
            $table->id();
            $table->string('ledger_type')->nullable();
            $table->timestamps();
        });

        Artisan::call('db:seed', [
            '--class' => 'LedgerTypeSeeder'
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ledger_types');
    }
}
