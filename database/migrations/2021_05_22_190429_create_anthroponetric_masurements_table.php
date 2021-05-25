<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnthroponetricMasurementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('anthroponetric_masurements', function (Blueprint $table) {
           $table->increments('id');
            $table->float('peso');
            $table->float('longitud_supia');
            $table->float('perimetro_cefalico');
            $table->float('perimetro_brazo');
            $table->float('perimetro_muslo');
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
        Schema::dropIfExists('anthroponetric_masurements');
    }
}
