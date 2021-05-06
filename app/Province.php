<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    protected $fillable = [
        'name', 'code',
    ];

    public function cantons () {
        return $this->hasMany('App\Canton', 'province_id', 'id');
    }
}
