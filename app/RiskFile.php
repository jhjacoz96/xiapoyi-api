<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RiskFile extends Model
{
    protected $fillable = [
        'id', 'file_family_id', 'risk_id', 'compromiso_id', 'cumplio', 'causas', 'level_risk_id', 'fecha_evaluacion', 'fecha_programacion'
    ];

    public function levelRisk () {
    	return $this->belongsTo('App\LevelRisk', 'level_risk_id', 'id');
    }

    public function risk () {
    	return $this->belongsTo('App\Risk', 'risk_id', 'id');
    }

}
