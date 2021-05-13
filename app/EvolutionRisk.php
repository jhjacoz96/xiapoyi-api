<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EvolutionRisk extends Model
{
    protected $fillable = [
        'compromiso_familiar', 'compromiso_equipo', 'cumplio', 'causas',
    ];
}
