<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class FixFieldDiabeticTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::table('diabetics', function (Blueprint $table) {
            /*$table->id();
            $table->string('title')->nullable();
            $table->text('description1')->nullable();
            $table->text('description2')->nullable();
            $table->timestamps();*/
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
