<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class Pathology extends Model implements Auditable
{
	use AuditableTrait;
	
    protected $fillable = [
        'name', 'description', 'capture',
    ];

    public function members () {
        return  $this->belongsToMany('App\Member','member_pathologies','member_id','pathology_id');
    }
}
