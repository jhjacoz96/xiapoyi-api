<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TypeDocument extends Model
{
     protected $fillable = [
        'nombre',
    ];

    public function employees () {
        return $this->hasMany('App\Employee', 'type_document_id', 'id');
    }
}
