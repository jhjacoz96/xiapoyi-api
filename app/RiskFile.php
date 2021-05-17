<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RiskFile extends Model
{
    protected $fillable = [
        'id', 'file_family_id', 'risk_id', 'compromiso_familiar', 'compromiso_equipo', 'cumplio', 'causas', 'level_risk_id',
    ];

}
