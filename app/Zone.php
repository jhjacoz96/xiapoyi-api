<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class Zone extends Model implements Auditable
{
	 use AuditableTrait;
	
    protected $fillable = [
        'name', 'code', 'canton_id', 'province_id'
    ];
    public function canton () {
        return $this->beolongsTo('App\Canton', 'canton_id', 'id');
    }
}
