<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuestionQualificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('question_qualifications', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('qualification_id')->unsigned();
            $table->foreign('qualification_id')->references('id')->on('qualifications')->onDelete('cascade');
            $table->integer('qualification_question_id')->unsigned();
            $table->foreign('qualification_question_id')->references('id')->on('qualification_questions')->onDelete('cascade');
            $table->integer('qualification_level_id')->unsigned();
            $table->foreign('qualification_level_id')->references('id')->on('qualification_levels')->onDelete('cascade');
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
        Schema::dropIfExists('question_qualifications');
    }
}
