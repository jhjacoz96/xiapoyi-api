<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRiskActivityEvolutionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('risk_activity_evolutions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('activity_evolution_id')->unsigned();
            $table->foreign('activity_evolution_id')->references('id')->on('activity_evolutions')->onDelete('cascade');
            $table->integer('risk_id')->unsigned();
            $table->foreign('risk_id')->references('id')->on('risks')->onDelete('cascade');
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
        Schema::dropIfExists('risk_activity_evolutions');
    }
}
