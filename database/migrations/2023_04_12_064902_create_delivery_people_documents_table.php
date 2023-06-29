<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeliveryPeopleDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('delivery_people_documents', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('delivery_people_id');
            $table->foreign('delivery_people_id')->references('id')->on('delivery_people');
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
        Schema::dropIfExists('delivery_people_documents');
    }
}
