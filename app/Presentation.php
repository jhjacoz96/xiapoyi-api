<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class Presentation extends Model implements Auditable
{
	 use AuditableTrait;
	
    protected $fillable = [
        'name', 'description',
    ];

    public function medicines () {
        return $this->hasMany('App\Medicine', 'presentation_id', 'id');
    }

}
