<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = [
        'pregunta',
        'respuesta',
        'nombre',
        'correo',
        'type_comment_id',
    ];

     public function typeComment () {
        return $this->belongsTo('App\TypeComment', 'type_comment_id', 'id');
    }
}
