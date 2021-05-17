<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDiabeticPatientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('diabetic_patients', function (Blueprint $table) {
            $table->increments('id');
            $table->string('presion_arterial')->nullable();
            $table->string('pulso')->nullable();
            $table->string('respiracion')->nullable();
            $table->string('saturacion_oxigeno')->nullable();
            $table->string('temperatura')->nullable();
            $table->float('peso')->nullable();
            $table->float('altura')->nullable();
            $table->string('circunferencia')->nullable();
            $table->string('abdominal')->nullable();
            $table->float('nivel_glusemia')->nullable();
            $table->string('dieta')->nullable();
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('diabetic_patients');
    }
}
