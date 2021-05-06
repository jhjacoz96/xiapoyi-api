<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('document');
            $table->string('phone');
            $table->string('address');
            $table->integer('canton_id')->unsigned()->nullable();
            $table->integer('province_id');
            $table->integer('user_id')->unsigned()->nullable();
            $table->integer('type_document_id')->unsigned();
            $table->integer('gender_id')->unsigned();
            $table->integer('type_employee_id')->unsigned()->nullable();
            $table->integer('specialty_id')->unsigned()->nullable();
            $table->timestamps();
        });
        Schema::table('employees', function($table) {
            $table->foreign('canton_id')->references('id')->on('cantons')->onDelete('cascade');
            $table->foreign('gender_id')->references('id')->on('genders')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('type_document_id')->references('id')->on('type_documents')->onDelete('cascade');
            $table->foreign('type_employee_id')->references('id')->on('type_employees')->onDelete('cascade');
            $table->foreign('specialty_id')->references('id')->on('specialties')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employees');
    }
}
