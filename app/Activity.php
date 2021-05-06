<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $fillable = [
        'nombre', 'descripcion', 'service_id'
    ];

    public function service () {
        return $this->belongsTo ('App\Service', 'service_id', 'id');
    }
}
