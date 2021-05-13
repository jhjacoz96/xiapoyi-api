<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldCausaFielRisksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('risk_files', function (Blueprint $table) {
             $table->string('compromiso_familiar')->nullable();
            $table->string('compromiso_equipo')->nullable();
            $table->string('cumplio')->nullable();
            $table->string('causas')->nullable();
            
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
