<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsSuscriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::table('suscriptions', function (Blueprint $table) {
            $table->integer('filter_two_publication_id')->unsigned()->nullable();
            $table->foreign('filter_two_publication_id')->references('id')->on('filter_two_publications')->onDelete('cascade');
            $table->integer('filter_one_publication_id')->unsigned()->nullable();
            $table->foreign('filter_one_publication_id')->references('id')->on('filter_one_publications')->onDelete('cascade');
            $table->integer('filter_three_publication_id')->unsigned()->nullable();
            $table->foreign('filter_three_publication_id')->references('id')->on('filter_three_publications')->onDelete('cascade');      
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
