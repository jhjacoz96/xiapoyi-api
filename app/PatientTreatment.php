<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PatientTreatment extends Model
{
    protected $fillable = [
        'dosis', 'hora', 'measure_id', 'medicine_id', 'presentation_id', 'diabetic_patient_id'
    ];

    public function measure () {
    	return $this->belongsTo('App\Measure', 'measure_id', 'id');
    }

    public function medicine () {
    	return $this->belongsTo('App\Medicine', 'medicine_id', 'id');
    }

    public function presentation () {
    	return $this->belongsTo('App\Presentation', 'presentation_id', 'id');
    }

    public function registerTreatment () {
    	return $this->hasMany('App\RegisterTreatment', 'patient_treatment_id', 'id');
    }
}
