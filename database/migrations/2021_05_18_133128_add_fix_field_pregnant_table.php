<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFixFieldPregnantTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pregnants', function (Blueprint $table) {
            $table->dropForeign('pregnants_type_blood_id_foreign');
            $table->dropColumn('type_blood_id');
        }); 
        Schema::table('pregnants', function (Blueprint $table) {
            $table->integer('type_blood_id')->unsigned()->nullable();
            $table->foreign('type_blood_id')->references('id')->on('type_bloods')->onDelete('cascade');
        });
        Schema::table('pregnant_phones', function (Blueprint $table) {
            $table->dropForeign('pregnant_phones_pregnant_id_foreign');
            $table->dropColumn('pregnant_id');
        }); 
        Schema::table('pregnant_phones', function (Blueprint $table) {
            $table->integer('pregnant_id')->unsigned()->nullable();
            $table->foreign('pregnant_id')->references('id')->on('pregnants')->onDelete('cascade');
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
