<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsMortalitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mortalities', function (Blueprint $table) {
            $table->dropColumn('causa');
        });
        Schema::table('mortalities', function (Blueprint $table) {
            $table->dateTime('fecha_fallecimiento')->nullable();
            $table->integer('member_id')->unsigned()->nullable();
            $table->foreign('member_id')->references('id')->on('members')->onDelete('cascade');
            $table->integer('cause_mortality_id')->unsigned()->nullable();
            $table->foreign('cause_mortality_id')->references('id')->on('cause_mortalities')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
