<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CauseContamination extends Model
{
    protected $fillable = [
        'nombre'
    ];

    public function contaminations () {
		return  $this->belongsToMany('App\Contamination','contamination_contaminations', 'cause_contamination_id','contamination_id');
	}
}
