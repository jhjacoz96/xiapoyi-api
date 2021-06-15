<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ActivityTreatment extends Model
{
    protected $fillable = [
        'actividad', 'duracion', 'hora', 'diabetic_patient_id',
    ];

    public function registerActivity () {
    	return $this->hasMany('App\RegisterActivity', 'activity_treatment_id', 'id');
    }

    public function diabeticPatient () {
    	return $this->belongsTo('App\DiabeticPatient', 'diabetic_patient_id', 'id');
    }

}
