<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VaccineDt extends Model
{
     protected $fillable = [
        'nombre'
    ];

    public function pregnants () {
        return  $this->belongsToMany('App\Pregnant','pregnant_vaccines','vaccine_dt_id','pregnant_id');
    }
}

