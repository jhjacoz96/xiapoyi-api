<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('members', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre');
            $table->string('apellido');
            $table->string('cedula')->unique();
            $table->string('correo')->nullable();
            $table->string('ocupacion');
            $table->dateTime('fecha_nacimiento');
            $table->boolean('vacunacion')->default(false);
            $table->boolean('salud_bucal')->default(false);
            $table->string('edad')->nullable();
            $table->boolean('embarazo')->default(false);
            $table->integer('scholarship_id')->unsigned()->nullable();
            $table->foreign('scholarship_id')->references('id')->on('scholarships')->onDelete('cascade');
            $table->integer('relationship_id')->unsigned();
            $table->foreign('relationship_id')->references('id')->on('relationships')->onDelete('cascade');
            $table->integer('gender_id')->unsigned();
            $table->foreign('gender_id')->references('id')->on('genders')->onDelete('cascade');
            $table->integer('type_document_id')->unsigned();
            $table->foreign('type_document_id')->references('id')->on('type_documents')->onDelete('cascade');
            $table->integer('file_family_id')->unsigned();
            $table->foreign('file_family_id')->references('id')->on('file_families')->onDelete('cascade');
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
        Schema::dropIfExists('members');
    }
}
