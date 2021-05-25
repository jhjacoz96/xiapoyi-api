<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFixFieldsPregnantTable extends Migration
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
            $table->dropColumn('semana_gestacion');
            $table->dropColumn('gestas');
            $table->dropColumn('partos');
            $table->dropColumn('abortos');
            $table->dropColumn('cesarias');
            $table->dropColumn('vaccine_dt');
        }); 
        Schema::table('pregnants', function (Blueprint $table) {
            $table->dateTime('fum')->nullable();
            $table->string('antecedentes_patologicos')->nullable();
            $table->integer('semana_gestacion')->nullable();
            $table->integer('gestas')->nullable();
            $table->integer('partos')->nullable();
            $table->integer('abortos')->nullable();
            $table->integer('cesarias')->nullable();
            $table->string('vaccine_dt')->nullable();
            $table->string('descripcion_gestacion')->nullable();
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
