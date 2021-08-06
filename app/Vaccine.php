<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class Vaccine extends Model implements Auditable
{
	use AuditableTrait;
	
    protected $fillable = [
        'name', 'description',
    ];
}
