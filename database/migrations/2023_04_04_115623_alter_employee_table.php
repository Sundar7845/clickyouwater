<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterEmployeeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->string('personal_mobile')->nullable()->after('dob');
            $table->string('official_mobile')->nullable()->after('personal_mobile');
            $table->string('personal_email')->nullable()->after('official_mobile');
            $table->string('official_email')->nullable()->after('personal_email');
            $table->string('relationship1')->nullable()->after('official_email');
            $table->string('relationship2')->nullable()->after('relationship1');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->dropColumn('personal_mobile')->nullable();
            $table->dropColumn('official_mobile')->nullable();
            $table->dropColumn('personal_email')->nullable();
            $table->dropColumn('official_email')->nullable();
            $table->dropColumn('relationship1')->nullable();
            $table->dropColumn('relationship2')->nullable();
        });
    }
}
