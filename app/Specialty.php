<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class Specialty extends Model implements Auditable
{
	use AuditableTrait;
	
    protected $fillable = [
        'name', 'description',
    ];

    public function Employees () {
        return $this->hasMany('App\Employee', 'type_employee_id', 'id');
    }
}
