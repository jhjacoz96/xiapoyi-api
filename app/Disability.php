<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class Disability extends Model implements Auditable
{
	use AuditableTrait;

    protected $fillable = [
        'name', 'description',
    ];

    public function members () {
        return  $this->belongsToMany('App\Member','member_disabilities','member_id','disability_id');
    }
}
