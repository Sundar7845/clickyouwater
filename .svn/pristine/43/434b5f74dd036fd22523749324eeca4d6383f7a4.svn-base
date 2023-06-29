<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schema;

class CreateWalletTransactionTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wallet_transaction_types', function (Blueprint $table) {
            $table->id();
            $table->string('wallet_transaction_type')->nullable();
        });

        Artisan::call('db:seed', [
            '--class' => 'WalletTransactionTypeSeeder'
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wallet_transaction_types');
    }
}
