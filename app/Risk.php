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
}
