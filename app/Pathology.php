<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pathology extends Model
{
    protected $fillable = [
        'name', 'description', 'capture',
    ];

    public function members () {
        return  $this->belongsToMany('App\Member','member_pathologies','member_id','pathology_id');
    }
}
