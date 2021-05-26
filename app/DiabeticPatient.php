<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DiabeticPatient extends Model
{
    protected $fillable = [
        'presion_arterial', 'pulso', 'respiracion', 'saturacion_oxigeno', 'temperatura', 'peso', 'altura', 'circunferencia', 'abdominal', 'nivel_glusemia', 'dieta', 'user_id', 'member_id'
    ];


    public function user () {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }

    public function medicines () {
        return  $this->belongsToMany('App\Medicine','patient_treatments', 'diabetic_patient_id','medicine_id')->withPivot('dosis', 'hora', 'measure_id', 'id');
    }

    public function activityTreatments () {
        return $this->hasMany('App\ActivityTreatment', 'diabetic_patient_id', 'id');
    }

    public function registerGlucose () {
        return $this->hasMany('App\RegisterGlucose', 'diabetic_patient_id', 'id');
    }

    public function member () {
        return $this->belongsTo('App\Member', 'member_id', 'id');
    }

    public function assignTratamientoNoFarmacologico (array $data) {
        $children = $this->activityTreatments;
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
            $this->activityTreatments->map(function ($c) use ($model) {
                $c->updateOrCreate([
                    'id' => $model['id'],
                  
                ],[
                    "actividad" => $model['actividad'],
                    "duracion" => $model['duracion'],
                    "hora" => $model["hora"],
                    "diabetic_patient_id" => $model['diabetic_patient_id'],
             ]);
            });
        });


        $attachments = $site_items->filter(function ($model) {
            return !isset($model['id']);
        })->map(function ($model) use ($deleted_ids) {
            if (count($deleted_ids) > 0) $model['id'] = $deleted_ids->pop();
            return $model;
        })->toArray();

        $this->activityTreatments()->createMany($attachments);
    }

}
