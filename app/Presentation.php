<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Presentation extends Model
{
    protected $fillable = [
        'name', 'description',
    ];

    public function medicines () {
        return $this->hasMany('App\Medicine', 'presentation_id', 'id');
    }

}
