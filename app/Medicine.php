<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Medicine extends Model
{
    protected $fillable = [
        'name', 'description', 'presentation_id'
    ];

    public function presentation () {
        return $this->belongsTo('App\Presentation', 'presentation_id', 'id');
    }

    public function diabeticPatients () {
        return  $this->belongsToMany('App\DiabeticPatient','patient_treatments', 'medicine_id','diabetic_patient_id')->withPivot('dosis', 'hora', 'measure_id', 'id');
    }

}
