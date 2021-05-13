<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mortality extends Model
{
    protected $fillable = [
        'nombre', 'apellido', 'edad', 'causa', 'file_famyly_id', 'relationship_id',
    ];

    public function fileFamily () {
       return $this->belognsTo('App\FileFamily', 'file_famyly_id', 'id');
    }
}
