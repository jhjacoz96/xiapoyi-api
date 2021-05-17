<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ActivityTreatment extends Model
{
    protected $fillable = [
        'actividad', 'duracion', 'hora', 'diabetic_patient_id',
    ];

}
