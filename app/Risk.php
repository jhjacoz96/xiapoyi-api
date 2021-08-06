<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;


class Risk extends Model  implements Auditable
{
    use AuditableTrait;

    protected $fillable = [
        'name', 'risk_classification_id'
    ];

    public function riskClassification () {
       return $this->belongsTo('App\RiskClassification', 'risk_classification_id', 'id');
    }

    public function FileFamilies () {
        return  $this->belongsToMany('App\FileFamily','risk_files','risk_id','file_family_id')->withPivot('compromiso_id', 'cumplio', 'causas', 'level_risk_id', 'fecha_evaluacion', 'fecha_programacion', 'id');
    }

    public function activityEvolutions () {
        return  $this->belongsToMany('App\ActivityEvolution','risk_activity_evolutions','risk_id','activity_evolution_id');
    }
}
