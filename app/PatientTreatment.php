<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PatientTreatment extends Model
{
    protected $fillable = [
        'dosis', 'hora', 'measure_id', 'medicine_id', 'presentation_id', 'diabetic_patient_id'
    ];
}
