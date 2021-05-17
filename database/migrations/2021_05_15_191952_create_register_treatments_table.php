<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRegisterTreatmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('register_treatments', function (Blueprint $table) {
            $table->increments('id');
            $table->dateTime('fecha');
            $table->timestamps();
        });
        Schema::table('register_treatments', function (Blueprint $table) {
            $table->integer('patient_treatment_id')->unsigned();
            $table->foreign('patient_treatment_id')->references('id')->on('patient_treatments')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('register_treatments');
    }
}
