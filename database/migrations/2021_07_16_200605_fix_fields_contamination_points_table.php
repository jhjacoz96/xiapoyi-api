<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class FixFieldsContaminationPointsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('contamination_points', function (Blueprint $table) {
            $table->dropColumn('tipo_contaminación');
            $table->dropColumn('causas');
            $table->integer('contamination_id')->unsigned()->nullable();
            $table->foreign('contamination_id')->references('id')->on('contaminations')->onDelete('cascade');
            $table->integer('cause_contamination_id')->unsigned()->nullable();
            $table->foreign('cause_contamination_id')->references('id')->on('cause_contaminations')->onDelete('cascade');
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
