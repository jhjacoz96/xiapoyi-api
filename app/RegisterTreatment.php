<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RegisterTreatment extends Model
{
	protected $fillable = [
        'fecha', 'patient_treatment_id',
    ];
    
    public function patientTreatment () {
    	return $this->belongsTo('App\PatientTreatment', 'patient_treatment_id', 'id');
    }
}
