<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVitalSignsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vital_signs', function (Blueprint $table) {
             $table->increments('id');
            $table->float('frecuencia_cardiaca');
            $table->float('frecuencia_respiratoria');
            $table->float('presion_arterial');
            $table->float('saturacion');
            $table->float('temperatura');
            $table->integer('file_clinical_neonatology_id')->unsigned()->nullable();
            $table->foreign('file_clinical_neonatology_id')->references('id')->on('file_clinical_neonatologies')->onDelete('cascade');
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
        Schema::dropIfExists('vital_signs');
    }
}
