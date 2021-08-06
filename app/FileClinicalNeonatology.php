<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class FileClinicalNeonatology extends Model implements Auditable
{
    use AuditableTrait;
    
    protected $fillable = [
        'numero_historia',
        'lugar_naciento',
        'pregnant_id',
        'member_id',
        'type_boold_mother_id',
        'type_boold_father_id',
        'edad_gestacional',
        'alimentacion_neonato',
        'aplicacion_vitamina',
        'gestation_week_id',
        'alergina_leche_materna',
        'peso',
        'perimetro_abdominal',
        'perimetro_cefalico',
        'perimetro_toracico',
        'longitu_cefalo_caudal',
        'temperatura',
        'profilaxis',
        'supuración',
        'posicion',
        'estado',
        'respiracion',
        'piel',
        'tonicidad',
        'cordon_umbilical',
        'orina',
        'deposiciones',
        'vomitos',
        'coordinacion_motora',
        'extreminades',
        'genitales',
        'frecuencia_cardiaca',
        'esfuerzo_respiratorio',
        'tono_muscular',
        'irritabilidad',
        'color_piel',
        'total_apgar',
        'forma_pezon',
        'textura_piel',
        'forma_oreja',
        'tamano_tejido',
        'pliegue_plantares',
        'total_test_capurro',
        'movimiento_taraco',
        'tijera_intercostal',
        'retraccion_xifoidea',
        'aleteo_nasal',
        'quejido_respiratorio',
        'total_escala_silverman',
        'bcg',
        'hb',
        'rotavirus',
        'fipv',
        'bopv',
        'pentavaliente',
        'neumococo',
        'influenza_estacionaria',
        'created_at',
    ];

    public function alterationPregnants () {
       return $this->belongsToMany('App\AlterationPregnant', 'alteration_neonatologies', 'file_clinical_neonatology_id', 'alteration_pregnant_id');
    }

    public function pathologyNeonatals () {
       return $this->belongsToMany('App\PathologyNeonatal', 'pathology_neonatal_files', 'file_clinical_neonatology_id', 'pathology_neonatal_id');
    }

    public function pathologyPregnants () {
       return $this->belongsToMany('App\PathologyPregnant', 'pathology_neonatologies', 'file_clinical_neonatology_id', 'pathology_pregnant_id');
    }

    public function pathologyFathers () {
       return $this->belongsToMany('App\Pathology', 'phatology_family_files', 'file_clinical_neonatology_id', 'pathology_id');
    }

    public function reflexes () {
       return $this->belongsToMany('App\Reflex', 'reflex_neonatals', 'file_clinical_neonatology_id', 'reflex_id');
    }
     
    public function vitalSigns () {
       return $this->hasMany('App\VitalSign', 'file_clinical_neonatology_id', 'id');
    }

    public function antroponetricMasurent () {
       return $this->hasMany('App\AntroponetricMasurent', 'file_clinical_neonatology_id', 'id');
    }

    public function pregnant () {
       return $this->belongsTo('App\Pregnant', 'pregnant_id', 'id');
    }

    public function member () {
       return $this->belongsTo('App\Member', 'member_id', 'id');
    }

    public function gestationWeek () {
       return $this->belongsTo('App\GestationWeek', 'gestation_week_id', 'id');
    }

}
