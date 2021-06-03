<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class FixFieldUsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('us', function (Blueprint $table) {
            $table->dropColumn('description1')->nullable();
            $table->dropColumn('description2')->nullable();
            $table->dropColumn('mission')->nullable();
            $table->dropColumn('vision')->nullable();
            $table->dropColumn('objective')->nullable();
            $table->dropColumn('value')->nullable();
        });

         Schema::table('us', function (Blueprint $table) {
            $table->text('description1')->nullable();
            $table->text('description2')->nullable();
            $table->text('mission')->nullable();
            $table->text('vision')->nullable();
            $table->text('objective')->nullable();
            $table->text('value')->nullable();
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
