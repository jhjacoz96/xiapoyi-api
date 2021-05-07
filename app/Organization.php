<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
    protected $fillable = [
        'name', 'institution_id', 'province_id', 'canton_id', 'address'
    ];
}
