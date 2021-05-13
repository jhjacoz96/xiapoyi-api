<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePregnantVaccinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pregnant_vaccines', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('vaccine_dt_id')->unsigned();
            $table->foreign('vaccine_dt_id')->references('id')->on('vaccine_dts')->onDelete('cascade');
            $table->integer('pregnant_id')->unsigned();
            $table->foreign('pregnant_id')->references('id')->on('pregnants')->onDelete('cascade');
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
        Schema::dropIfExists('pregnant_vaccines');
    }
}
