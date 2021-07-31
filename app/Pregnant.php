<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pregnant extends Model
{
    protected $fillable = [
        'fum', 'fpp', 'antecentedes_patologicos', 'semana_gestacion', 'gestas', 'partos', 'abortos', 'cesarias', 'member_id', 'created_at', 'employee_id',
        'type_blood_id',
        'estado_civil',
        'vive_con',
        'recomendaciones',
        'numero_historia',
        'antecentedes_paternos',
        'antecentedes_maternos',
        'antecentedes_prenatales',
        'medicamentos',
        'embarazo_planificado',
        'descripcion_gestacion',
        'causa_embarazo',
        'ayuda_violacion',
        'ayuda_anticoceptivo',
        'talla',
        'peso',
        'dar_luz',
        'nombre_acompanate',
        'aceptaria_formula',
        'estimulacion_embarazo',
        'administrar_hemoderivado',
        'capacitacion_prenatal',
        'capacitacion_epidural',
        'observacion_parto',
        'hemorragia',
       'desgarro',
        'grado_desgarro',
        'tipo_parto',
        'episiorria',
        'hemorroides',
        'dolor',
        'epitomia',
        'grado_epitomia',
        'loquios',
        'involucion_uterina',
        'dolor_eva',
        'educacion_lactancia',
        'satisfaccion_lactancia',
        'score_mama_inmediato',
        'score_mama_mediato',
        'educacion_paciente',
        'educacion_depresion',
        'proporcionar_telefono',
        'señal_alarma',
        'gestation_week_id',
    ];

    public function member () {
        return $this->belongsTo('App\Member','member_id', 'id');
    }

    public function gestationWeek () {
        return $this->belongsTo('App\GestationWeek','gestation_week_id', 'id');
    }

    public function vaccineDts () {
        return  $this->belongsToMany('App\VaccineDt','pregnant_vaccines','pregnant_id','vaccine_dt_id');
    }

    public function medicines () {
        return  $this->belongsToMany('App\Medicine','medicine_pregnants','pregnant_id','medicine_id')->withPivot('dosis', 'presentation_id', 'measure_id', 'frequency_id', 'id');
    }

    public function senalAlarms () {
        return  $this->belongsToMany('App\SenalAlarm','senal_alarm_pregnants','pregnant_id','senal_alarm_id');
    }

    
    public function vaccines () {
        return  $this->belongsToMany('App\Vaccine','vaccine_pregnants','pregnant_id','vaccine_id');
    }

    public function psychotrophics () {
        return  $this->belongsToMany('App\PsychotrophicSubstance','psychotrophic_pregnants','pregnant_id','psychotrophic_id');
    }

    public function pregnantPhones () {
        return $this->hasMany('App\PregnantPhone', 'pregnant_id', 'id');
    }

    public function examRoutines () {
        return  $this->belongsToMany('App\ExamRoutine','exam_pregnants','pregnant_id','exam_routine_id');
    }

    public function pathologyPregnants () {
        return  $this->belongsToMany('App\PathologyPregnant', 'pathology_pregnant_pregnants', 'pregnant_id', 'pathology_pregnant_id');
    }

    public function pathologyMothers () {
        return  $this->belongsToMany('App\Pathology', 'pathology_mother_pregnants', 'pregnant_id', 'pathology_mother_pregnant_id');
    }

    public function pathologyFathers () {
        return  $this->belongsToMany('App\Pathology', 'pathology_father_pregnants', 'pregnant_id', 'pathology_father_pregnant_id');
    }

    public function fileClinicalNeonatology () {
        return  $this->hasMany('App\FileClinicalNeonatology','pregnant_id', 'id');
    }


    public function assignPhones (array $data) {
        $children = $this->pregnantPhones;
        $site_items = collect($data);
        $deleted_ids = [];
        if (count($children) > 0) {
            $deleted_ids = $children->filter(function ($child) use ($site_items) {
                return empty($site_items->where('id', $child->id)->first());
            })->map(function ($child) {
                $id = $child->id;
                $child->delete();
                return $id;
            });
        }

        

        $updates = $site_items->filter(function ($model) {
            return isset($model['id']);
        })->map(function ($model) {
            $this->pregnantPhones->map(function ($c) use ($model) {
                $c->updateOrCreate([
                    'id' => $model['id'],
                  
                ],[
                    "nombre" => $model['nombre'],
                    "telefono" => $model['telefono'],
                    "relationship_id" => $model["relationship_id"],
                    "pregnant_id" => $model['pregnant_id'],
             ]);
            });
        });


        $attachments = $site_items->filter(function ($model) {
            return !isset($model['id']);
        })->map(function ($model) use ($deleted_ids) {
            if (count($deleted_ids) > 0) $model['id'] = $deleted_ids->pop();
            return $model;
        })->toArray();
        $this->pregnantPhones()->createMany($attachments);
    }


}
