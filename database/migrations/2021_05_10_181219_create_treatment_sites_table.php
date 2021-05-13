<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTreatmentSitesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('treatment_sites', function (Blueprint $table) {
            $table->increments('id');
            $table->string('lugar');
            $table->integer('file_famyly_id')->unsigned();
            $table->foreign('file_famyly_id')->references('id')->on('file_families')->onDelete('cascade');
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
        Schema::dropIfExists('treatment_sites');
    }
}
