<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Disability extends Model
{
    protected $fillable = [
        'name', 'description',
    ];

    public function members () {
        return  $this->belongsToMany('App\Member','member_disabilities','member_id','disability_id');
    }
}
