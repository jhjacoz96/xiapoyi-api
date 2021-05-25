<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFileClinicalNeonatologiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('file_clinical_neonatologies', function (Blueprint $table) {
            $table->increments('id');
            ////----------------------Datos basicos--------------------//
            $table->string('numero_historia')->unique();
            $table->string('lugar_naciento')->nullable();
            $table->integer('pregnant_id')->unsigned();
            $table->foreign('pregnant_id')->references('id')->on('pregnants')->onDelete('cascade');
            $table->integer('member_id')->unsigned();
            $table->foreign('member_id')->references('id')->on('members')->onDelete('cascade');

            // Antecedentes prenatales
            $table->integer('type_boold_mother_id')->unsigned()->nullable();
            $table->foreign('type_boold_mother_id')->references('id')->on('type_bloods')->onDelete('cascade');
            $table->integer('type_boold_father_id')->unsigned()->nullable();
            $table->foreign('type_boold_father_id')->references('id')->on('type_bloods')->onDelete('cascade');
            // Antecedentes postnatal
            $table->integer('edad_gestacional')->nullable();
            $table->integer('gestation_week_id')->unsigned()->nullable();
            $table->foreign('gestation_week_id')->references('id')->on('gestation_weeks')->onDelete('cascade');
            $table->string('alimentacion_neonato')->nullable();
            $table->boolean('aplicacion_vitamina')->nullable();
            $table->boolean('alergina_leche_materna')->nullable();
            // -----------------------Valoracion------------------------------- //
            // Medidas Antropométrica
            $table->string('peso')->nullable();
            $table->string('perimetro_abdominal')->nullable();
            $table->string('perimetro_cefalico')->nullable();
            $table->string('perimetro_toracico')->nullable();
            $table->string('longitu_cefalo_caudal')->nullable();
            $table->string('temperatura')->nullable();
            // Ojos
            $table->boolean('profilaxis')->nullable();
            $table->boolean('supuración')->nullable();
            $table->string('posicion')->nullable();
            $table->string('estado')->nullable();

            $table->string('respiracion')->nullable();
            $table->string('piel')->nullable();
            $table->string('tonicidad')->nullable();
            $table->string('cordon_umbilical')->nullable();

            $table->string('orina')->nullable();
            $table->string('deposiciones')->nullable();
            $table->string('vomitos')->nullable();
            $table->string('coordinacion_motora')->nullable();
            $table->string('extreminades')->nullable();
            $table->string('genitales')->nullable();

            // -----------------------Test------------------------------- //
            // apgar
            $table->integer('frecuencia_cardiaca')->nullable();
            $table->integer('esfuerzo_respiratorio')->nullable();
            $table->integer('tono_muscular')->nullable();
            $table->integer('irritabilidad')->nullable();
            $table->integer('color_piel')->nullable();
            $table->integer('total_apgar')->nullable();
            // test capurro
            $table->integer('forma_pezon')->nullable();
            $table->integer('textura_piel')->nullable();
            $table->integer('forma_oreja')->nullable();
            $table->integer('tamano_tejido')->nullable();
            $table->integer('pliegue_plantares')->nullable();
            $table->integer('total_test_capurro')->nullable();
            // escala silverman
            $table->integer('movimiento_taraco')->nullable();
            $table->integer('tijera_intercostal')->nullable();
            $table->integer('retraccion_xifoidea')->nullable();
            $table->integer('aleteo_nasal')->nullable();
            $table->integer('quejido_respiratorio')->nullable();
            $table->integer('total_escala_silverman')->nullable();

            // -----------------------vacunacion------------------------------- //
            $table->string('bcg')->nullable();
            $table->string('hb')->nullable();
            $table->string('rotavirus')->nullable();
            $table->string('fipv')->nullable();
            $table->string('bopv')->nullable();
            $table->string('pentavaliente')->nullable();
            $table->string('neumococo')->nullable();
            $table->string('influenza_estacionaria')->nullable();

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
        Schema::dropIfExists('file_clinical_neonatologies');
    }
}
