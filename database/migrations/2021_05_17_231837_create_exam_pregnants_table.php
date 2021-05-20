<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExamPregnantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exam_pregnants', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('exam_routine_id')->unsigned();
            $table->foreign('exam_routine_id')->references('id')->on('exam_routines')->onDelete('cascade');
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
        Schema::dropIfExists('exam_pregnants');
    }
}
