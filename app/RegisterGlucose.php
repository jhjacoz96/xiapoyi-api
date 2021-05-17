<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RegisterGlucose extends Model
{
    protected $fillable = [
        'fecha', 'nivel_glusemia', 'diabetic_patient_id',
    ];

    public function diabeticPatient () {
        return $this->belongsTo('App\DiabeticPatient', 'diabetic_patient_id', 'id');
    }
}
