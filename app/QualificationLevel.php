<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QualificationLevel extends Model
{
    protected $fillable = [
        'nombre', 'nivel'
    ];
}
