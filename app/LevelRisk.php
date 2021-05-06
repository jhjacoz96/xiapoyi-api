<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LevelRisk extends Model
{
    protected $fillable = [
        'name', 'color', 'value',
    ];
}
