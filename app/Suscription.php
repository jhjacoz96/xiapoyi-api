<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Suscription extends Model
{
    protected $fillable = [
        'nombre', 'correo',
    ];
}
