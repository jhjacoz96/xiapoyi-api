<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldssPregnantTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pregnants', function (Blueprint $table) {
            $table->dropColumn('fum');
            $table->dropColumn('antecedentes_patologicos');
            $table->dropColumn('vaccine_dt');
        });
        Schema::table('pregnants', function (Blueprint $table) {
            $table->dateTime('fum')->nullable();
            $table->string('antecedentes_patologicos')->nullable();
            $table->string('vaccine_dt')->nullable();
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
