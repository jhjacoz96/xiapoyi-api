<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mortality extends Model
{
    protected $fillable = [
        'nombre', 'apellido', 'edad', 'causa', 'file_famyly_id', 'relationship_id',
    ];

    public function fileFamily () {
       return $this->belongsTo('App\FileFamily', 'file_famyly_id', 'id');
    }
    public function relationship () {
       return $this->belongsTo('App\Relationship', 'relationship_id', 'id');
    }
}
