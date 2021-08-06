<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class CauseContamination extends Model implements Auditable
{
	use AuditableTrait;
	
    protected $fillable = [
        'nombre'
    ];

    public function contaminations () {
		return  $this->belongsToMany('App\Contamination','contamination_contaminations', 'cause_contamination_id','contamination_id');
	}
}
