<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RiskClassification extends Model
{
    protected $fillable = [
        'name'
    ];

    public function risks () {
        return $this->hasMany('App\Risk', 'risk_classification_id', 'id');
     }
}
