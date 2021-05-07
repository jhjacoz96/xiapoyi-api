<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Diabetic extends Model
{
    protected $fillable = [
        'title' ,'description1',  'description2'
    ];

    public function image(){
        return $this->morphOne('App\Image','imageable');
    }
}
