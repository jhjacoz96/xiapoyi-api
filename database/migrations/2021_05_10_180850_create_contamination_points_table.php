<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContaminationPointsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contamination_points', function (Blueprint $table) {
            $table->increments('id');
            $table->string('tipo_contaminación');
            $table->string('causas');
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
        Schema::dropIfExists('contamination_points');
    }
}
