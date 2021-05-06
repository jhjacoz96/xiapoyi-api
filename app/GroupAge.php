<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GroupAge extends Model
{
    protected $fillable = [
        'name', 'description', 'rank'
    ];
}
