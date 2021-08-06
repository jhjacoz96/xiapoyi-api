<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class RiskClassification extends Model implements Auditable
{
	 use AuditableTrait;

    protected $fillable = [
        'name'
    ];

    public function risks () {
        return $this->hasMany('App\Risk', 'risk_classification_id', 'id');
     }
}
