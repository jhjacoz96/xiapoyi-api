<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContaminationContaminationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contamination_contaminations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('contamination_id')->unsigned();
            $table->foreign('contamination_id')->references('id')->on('contaminations')->onDelete('cascade');
            $table->integer('cause_contamination_id')->unsigned();
            $table->foreign('cause_contamination_id')->references('id')->on('cause_contaminations')->onDelete('cascade');
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
        Schema::dropIfExists('contamination_contaminations');
    }
}
