<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class Activity extends Model
{
	use AuditableTrait;
	
    protected $fillable = [
        'nombre', 'descripcion', 'service_id'
    ];

    public function service () {
        return $this->belongsTo ('App\Service', 'service_id', 'id');
    }
}
