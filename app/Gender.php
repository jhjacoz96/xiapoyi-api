<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Gender extends Model
{
     protected $fillable = [
        'name',
    ];

    public function employees () {
        return $this->hasMany('App\Employee', 'gender_id', 'id');
    }
}
