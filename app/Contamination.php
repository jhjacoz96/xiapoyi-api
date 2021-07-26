<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contamination extends Model
{
    protected $fillable = [
        'nombre'
      ];

    public function causeContaminations () {
      return  $this->belongsToMany('App\CauseContamination','contamination_contaminations', 'contamination_id','cause_contamination_id');
    }
}