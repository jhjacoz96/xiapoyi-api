<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMortalitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mortalities', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre');
            $table->string('apellido');
            $table->string('edad');
            $table->string('causa');
            $table->integer('file_famyly_id')->unsigned();
            $table->foreign('file_famyly_id')->references('id')->on('file_families')->onDelete('cascade');
            $table->integer('relationship_id')->unsigned();
            $table->foreign('relationship_id')->references('id')->on('relationships')->onDelete('cascade');
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
        Schema::dropIfExists('mortalities');
    }
}
