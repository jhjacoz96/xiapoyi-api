<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class FixFieldssRiskFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('risk_files', function (Blueprint $table) {
             $table->dropColumn('compromiso_familiar');
            $table->dropColumn('compromiso_equipo');
        });
        Schema::table('risk_files', function (Blueprint $table) {
            $table->integer('compromiso_id')->unsigned()->nullable();
            $table->foreign('compromiso_id')->references('id')->on('activity_evolutions')->onDelete('cascade');
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
