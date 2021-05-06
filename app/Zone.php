<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Zone extends Model
{
    protected $fillable = [
        'name', 'code', 'canton_id', 'province_id'
    ];
    public function canton () {
        return $this->beolongsTo('App\Canton', 'canton_id', 'id');
    }
}
