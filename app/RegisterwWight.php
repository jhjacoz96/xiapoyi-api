<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RegisterwWight extends Model
{
    protected $fillable = [
        'fecha', 'peso', 'diabetic_patient_id', 'hora',
    ];

    public function diabeticPatient () {
        return $this->belongsTo('App\DiabeticPatient', 'diabetic_patient_id', 'id');
    }
}
