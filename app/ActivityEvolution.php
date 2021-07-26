<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ActivityEvolution extends Model
{
    protected $fillable = [
        'compromiso_familiar', 'compromiso_equipo'
    ];
}
