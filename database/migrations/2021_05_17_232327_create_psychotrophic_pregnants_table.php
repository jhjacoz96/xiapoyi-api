<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePsychotrophicPregnantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('psychotrophic_pregnants', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('psychotrophic_id')->unsigned();
            $table->foreign('psychotrophic_id')->references('id')->on('psychotrophic_substances')->onDelete('cascade');
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
        Schema::dropIfExists('psychotrophic_pregnants');
    }
}
