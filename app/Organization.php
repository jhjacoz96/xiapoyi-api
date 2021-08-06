<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class Organization extends Model implements Auditable
{
    use AuditableTrait;
    
    protected $fillable = [
        'name', 'institution_id', 'province_id', 'canton_id', 'address', 'code_uo', 'parroquia'
    ];

    public function institution () {
    	return $this->belongsTo('App\Institution', 'institution_id', 'id');
    }

    public function image(){
        return $this->morphOne('App\Image','imageable');
    }

    public function canton () {
    	return $this->belongsTo('App\Canton', 'canton_id', 'id');
    }

    public function province () {
    	return $this->belongsTo('App\Province', 'province_id', 'id');
    }
}
