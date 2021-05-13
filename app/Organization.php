<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
    protected $fillable = [
        'name', 'institution_id', 'province_id', 'canton_id', 'address', 'code_uo', 'parroquia'
    ];

    public function institution () {
    	return $this->belongsTo('App\Institution', 'institution_id', 'id');
    }

    public function canton () {
    	return $this->belongsTo('App\Canton', 'canton_id', 'id');
    }

    public function province () {
    	return $this->belongsTo('App\Province', 'province_id', 'id');
    }
}
