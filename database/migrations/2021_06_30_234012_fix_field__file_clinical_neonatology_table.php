<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class FixFieldFileClinicalNeonatologyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('file_clinical_neonatologies', function (Blueprint $table) {
            $table->dropColumn('peso');
        });
        Schema::table('file_clinical_neonatologies', function (Blueprint $table) {
            $table->double('peso')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

    }
}
