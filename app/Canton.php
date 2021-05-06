<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Canton extends Model
{
    protected $fillable = [
        'name', 'code',
    ];

    public function province () {
        return $this->belongsTo('App\Province', 'province_id', 'id');
    }

    public function zones () {
        return $this->hasMany('App\Zone', 'zone_id', 'id');
    }
}
