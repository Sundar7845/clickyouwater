<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterLogisticPartnerDocuments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('logistic_partner_documents', function (Blueprint $table) {
            $table->dropForeign(['documentconfig_id']);
            $table->dropColumn('documentconfig_id');
            $table->unsignedBigInteger('documenttype_id')->after('logistic_partner_id');
            $table->foreign('documenttype_id')->references('id')->on('document_types');
            $table->unsignedBigInteger('documentmodule_id')->after('documenttype_id');
            $table->foreign('documentmodule_id')->references('id')->on('document_modules');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('logistic_partner_documents', function (Blueprint $table) {
            $table->unsignedBigInteger('documentconfig_id');
            $table->foreign('documentconfig_id')->references('id')->on('document_configs');
            $table->dropForeign(['documenttype_id']);
            $table->dropColumn('documenttype_id');
            $table->dropForeign(['documentmodule_id']);
            $table->dropColumn('documentmodule_id');
        });
    }
}
