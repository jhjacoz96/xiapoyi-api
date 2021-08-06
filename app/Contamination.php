<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class Contamination extends Model implements Auditable
{
	use AuditableTrait;
	
    protected $fillable = [
        'nombre'
      ];

    public function causeContaminations () {
      return  $this->belongsToMany('App\CauseContamination','contamination_contaminations', 'contamination_id','cause_contamination_id');
    }
}