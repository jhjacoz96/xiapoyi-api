<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReflexNeonatalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reflex_neonatals', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('reflex_id')->unsigned();
            $table->foreign('reflex_id')->references('id')->on('reflexes')->onDelete('cascade');
            $table->integer('file_clinical_neonatology_id')->unsigned();
            $table->foreign('file_clinical_neonatology_id')->references('id')->on('file_clinical_neonatologies')->onDelete('cascade');
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
        Schema::dropIfExists('reflex_neonatals');
    }
}
