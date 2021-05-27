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
            $table->text('description1')->nullable();
            $table->text('description2')->nullable();
            $table->text('mission')->nullable();
            $table->text('vision')->nullable();
            $table->text('objective')->nullable();
            $table->text('value')->nullable();
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
