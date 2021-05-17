<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRegisterActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('register_activities', function (Blueprint $table) {
            $table->increments('id');
            $table->dateTime('fecha');
            $table->integer('activity_treatment_id')->unsigned();
            $table->foreign('activity_treatment_id')->references('id')->on('activity_treatments')->onDelete('cascade');
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
        Schema::dropIfExists('register_activities');
    }
}
