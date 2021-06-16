<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSenalAlarmPregnantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('senal_alarm_pregnants', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('senal_alarm_id')->unsigned();
            $table->integer('pregnant_id')->unsigned();
            $table->foreign('senal_alarm_id')->references('id')->on('senal_alarms')->onDelete('cascade');
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
        Schema::dropIfExists('senal_alarm_pregnants');
    }
}
