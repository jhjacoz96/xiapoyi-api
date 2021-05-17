<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRegisterGlucosesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('register_glucoses', function (Blueprint $table) {
            $table->increments('id');
            $table->dateTime('fecha');
            $table->float('nivel_glusemia');
            $table->integer('diabetic_patient_id')->unsigned();
            $table->foreign('diabetic_patient_id')->references('id')->on('diabetic_patients')->onDelete('cascade');
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
        Schema::dropIfExists('register_glucoses');
    }
}
