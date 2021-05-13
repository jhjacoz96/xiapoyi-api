<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePregnantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pregnants', function (Blueprint $table) {
            $table->increments('id');
            $table->dateTime('fum');
            $table->string('antecedentes_patologicos');
            $table->dateTime('fpp')->nullable();
            $table->integer('semana_gestacion');
            $table->integer('gestas');
            $table->integer('partos');
            $table->integer('abortos');
            $table->integer('cesarias');
            $table->integer('member_id')->unsigned();
            $table->foreign('member_id')->references('id')->on('members')->onDelete('cascade');
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
        Schema::dropIfExists('pregnants');
    }
}
