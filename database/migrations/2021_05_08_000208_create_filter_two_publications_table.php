<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFilterTwoPublicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('filter_two_publications', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('filter_one_publication_id')->unsigned();
            $table->foreign('filter_one_publication_id')->references('id')->on('filter_one_publications')->onDelete('cascade');
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
        Schema::dropIfExists('filter_two_publications');
    }
}
