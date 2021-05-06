<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LevelTotal extends Model
{
    protected $fillable = [
        'name', 'color', 'rank',
    ];
}
