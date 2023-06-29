<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateManufacturerDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('manufacturer_documents', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('manufacture_id');
            $table->foreign('manufacture_id')->references('id')->on('manufacturers');
            $table->unsignedBigInteger('documentconfig_id');
            $table->foreign('documentconfig_id')->references('id')->on('document_configs');
            $table->string('document_path')->nullable();
            $table->string('document_number')->nullable();
            $table->boolean('is_verified')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('manufacturer_documents');
    }
}
