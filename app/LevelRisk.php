<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class LevelRisk extends Model implements Auditable
{
	use AuditableTrait;
	
    protected $fillable = [
        'name', 'color', 'value',
    ];
}
