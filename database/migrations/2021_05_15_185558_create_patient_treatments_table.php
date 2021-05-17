<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePatientTreatmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patient_treatments', function (Blueprint $table) {
            $table->increments('id');
            $table->float('dosis');
            $table->string('hora');
            $table->integer('medicine_id')->unsigned();
            $table->foreign('medicine_id')->references('id')->on('medicines')->onDelete('cascade');
            $table->integer('diabetic_patient_id')->unsigned();
            $table->foreign('diabetic_patient_id')->references('id')->on('diabetic_patients')->onDelete('cascade');
            $table->integer('measure_id')->unsigned();
            $table->foreign('measure_id')->references('id')->on('measures')->onDelete('cascade');
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
        Schema::dropIfExists('patient_treatments');
    }
}
