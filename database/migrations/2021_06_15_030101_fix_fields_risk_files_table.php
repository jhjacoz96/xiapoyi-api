<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class FixFieldsRiskFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('risk_files', function (Blueprint $table) {
             $table->dropColumn('compromiso_familiar')->nullable();
            $table->dropColumn('compromiso_equipo')->nullable();
            $table->dropColumn('causas')->nullable();
        });
        Schema::table('risk_files', function (Blueprint $table) {
             $table->text('compromiso_familiar')->nullable();
            $table->text('compromiso_equipo')->nullable();
            $table->text('causas')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
