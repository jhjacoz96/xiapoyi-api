<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFileFamiliesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('file_families', function (Blueprint $table) {
            $table->increments('id');
            $table->string('manzana')->nullable();
            $table->string('direccion_habitual');
            $table->string('barrio')->nullable();
            $table->string('numero_familia');
            $table->string('numero_historia')->nullable();
            $table->string('numero_telefono')->nullable();
            $table->string('numero_casa');
            $table->string('total_risk')->nullable();
            $table->integer('zone_id')->unsigned();
            $table->foreign('zone_id')->references('id')->on('zones')->onDelete('cascade');
            $table->integer('level_total_id')->unsigned()->nullable();
            $table->foreign('level_total_id')->references('id')->on('level_totals')->onDelete('cascade');
            $table->integer('cultural_group_id')->unsigned()->nullable();
            $table->foreign('cultural_group_id')->references('id')->on('cultural_groups')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('file_families');
    }
}
