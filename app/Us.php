<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Us extends Model
{
    protected $fillable = [
        'description1', 'description1', 'description2', 'mission', 'vision', 'objective', 'value', 'image_vision', 'image_mission', 'image_objective', 'image_value', 'image_us'
    ];

    public function image(){
        return $this->morphMany('App\Image','imageable');
    }
}
