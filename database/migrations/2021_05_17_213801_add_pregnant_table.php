<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPregnantTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pregnants', function (Blueprint $table) {
            // datos generales
            $table->integer('type_blood_id')->unsigned()->nullable();
            $table->foreign('type_blood_id')->references('id')->on('type_bloods')->onDelete('cascade');
            $table->string('estado_civil')->nullable();
            $table->string('vive_con')->nullable();
            // antecedentes
            $table->string('antecentedes_paternos')->nullable();
            $table->string('antecentedes_maternos')->nullable();
            $table->string('antecentedes_prenatales')->nullable();
            $table->string('medicamentos')->nullable();
            // datos obstetricos
            $table->boolean('embarazo_planificado')->nullable();
            $table->string('causa_embarazo')->nullable();
            $table->string('ayuda_violacion')->nullable();
            $table->string('ayuda_anticoceptivo')->nullable();
            $table->float('talla')->nullable();
            $table->float('peso')->nullable();
            // planificacion parto
            $table->string('dar_luz')->nullable();
            $table->string('nombre_acompanate')->nullable();
            $table->boolean('aceptaria_formula')->nullable();
            $table->boolean('estimulacion_embarazo')->nullable();
            $table->boolean('administrar_hemoderivado')->nullable();
            $table->boolean('capacitacion_prenatal')->nullable();
            $table->boolean('capacitacion_epidural')->nullable();
             // parto
             $table->string('observacion_parto')->nullable();
             $table->boolean('hemorragia')->nullable();
             $table->boolean('desgarro')->nullable();
             $table->string('grado_desgarro')->nullable();
             $table->string('tipo_parto')->nullable();
             $table->boolean('episiorria')->nullable();
             $table->boolean('hemorroides')->nullable();
             $table->boolean('dolor')->nullable();
             $table->boolean('epitomia')->nullable();
             $table->string('grado_epitomia')->nullable();
             // purperio
             $table->boolean('loquios')->nullable();
             $table->boolean('involucion_uterina')->nullable();
             $table->integer('dolor_eva')->nullable();
             $table->boolean('educacion_lactancia')->nullable();
             $table->integer('satisfaccion_lactancia')->nullable();
             $table->integer('score_mama_inmediato')->nullable();
             $table->integer('score_mama_mediato')->nullable();
             $table->boolean('educacion_paciente')->nullable();
             $table->boolean('educacion_depresion')->nullable();
             $table->boolean('proporcionar_telefono')->nullable();
             $table->string('señal_alarma')->nullable();
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
