<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class Activity extends Model implements Auditable
{
	use AuditableTrait;
	
    protected $fillable = [
        'nombre', 'descripcion', 'service_id'
    ];

    public function service () {
        return $this->belongsTo ('App\Service', 'service_id', 'id');
    }
}
