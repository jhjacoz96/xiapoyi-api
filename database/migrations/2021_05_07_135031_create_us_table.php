<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('us', function (Blueprint $table) {
            $table->id();
            $table->string('description1')->nullable();
            $table->string('description2')->nullable();
            $table->string('mission')->nullable();
            $table->string('vision')->nullable();
            $table->string('objective')->nullable();
            $table->string('value')->nullable();
            $table->string('image_vision')->nullable();
            $table->string('image_mission')->nullable();
            $table->string('image_objective')->nullable();
            $table->string('image_value')->nullable();
            $table->string('image_us')->nullable();
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
        Schema::dropIfExists('us');
    }
}
