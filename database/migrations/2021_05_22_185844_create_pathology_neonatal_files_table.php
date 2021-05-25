<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePathologyNeonatalFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pathology_neonatal_files', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('pathology_neonatal_id')->unsigned();
            $table->foreign('pathology_neonatal_id')->references('id')->on('pathology_neonatals')->onDelete('cascade');
            $table->integer('file_clinical_neonatology_id')->unsigned();
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
        Schema::dropIfExists('pathology_neonatal_files');
    }
}
