<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEvolutionRisksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('evolution_risks', function (Blueprint $table) {
            $table->increments('id');
            $table->string('compromiso_familiar');
            $table->string('compromiso_equipo');
            $table->string('cumplio')->nullable();
            $table->string('causas')->nullable();
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
        Schema::dropIfExists('evolution_risks');
    }
}
