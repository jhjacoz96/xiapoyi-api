<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class Measure extends Model implements Auditable
{
	use AuditableTrait;
	
    protected $fillable = [
        'name', 'description',
    ];
}
