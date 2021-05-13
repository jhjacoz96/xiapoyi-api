<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRiskFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('risk_files', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('risk_id')->unsigned();
            $table->foreign('risk_id')->references('id')->on('risks')->onDelete('cascade');
            $table->integer('')->unsigned();
            $table->foreign('file_family_id')->references('id')->on('file_families')->onDelete('cascade');
            
            $table->integer('evolution_risk_id')->unsigned()->nullable();
            $table->foreign('evolution_risk_id')->references('id')->on('evolution_risks')->onDelete('cascade');
            $table->integer('level_risk_id')->unsigned();
            $table->foreign('level_risk_id')->references('id')->on('level_risks')->onDelete('cascade');
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
        Schema::dropIfExists('risk_files');
    }
}
