<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pathology extends Model
{
    protected $fillable = [
        'name', 'description', 'capture',
    ];
}
