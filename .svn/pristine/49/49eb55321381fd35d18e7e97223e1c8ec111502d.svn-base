<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogisticPartnerDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('logistic_partner_documents', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('logistic_partner_id');
            $table->foreign('logistic_partner_id')->references('id')->on('logistic_partners');
            $table->unsignedBigInteger('documentconfig_id');
            $table->foreign('documentconfig_id')->references('id')->on('document_configs');
            $table->string('document_path')->nullable();
            $table->string('document_number')->nullable();
            $table->boolean('is_verified')->default(0);
            $table->boolean('is_original')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('logistic_partner_documents');
    }
}
