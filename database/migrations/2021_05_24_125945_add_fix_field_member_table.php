<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFixFieldMemberTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('members', function (Blueprint $table) {
            $table->dropColumn('cedula');
            $table->dropColumn('ocupacion');
            $table->dropForeign('members_type_document_id_foreign');
            $table->dropColumn('type_document_id');
            $table->dropForeign('members_relationship_id_foreign');
            $table->dropColumn('relationship_id');
        });
        Schema::table('members', function (Blueprint $table) {
            $table->string('cedula')->unique()->nullable();
            $table->string('ocupacion')->nullable();
            $table->integer('relationship_id')->unsigned()->nullable();
            $table->foreign('relationship_id')->references('id')->on('relationships')->onDelete('cascade');
            $table->integer('type_document_id')->unsigned()->nullable();
            $table->foreign('type_document_id')->references('id')->on('type_documents')->onDelete('cascade');
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
