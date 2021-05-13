<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Risk extends Model
{
    protected $fillable = [
        'name', 'risk_classification_id'
    ];

    public function riskClassification () {
       return $this->belongsTo('App\RiskClassification', 'risk_classification_id', 'id');
    }

    public function FileFamilies () {
        return  $this->belongsToMany('App\FileFamily','risk_files','risk_id','file_family_id')->withPivot('compromiso_familiar', 'compromiso_equipo', 'cumplio', 'causas', 'level_risk_id', 'id');
    }
}
