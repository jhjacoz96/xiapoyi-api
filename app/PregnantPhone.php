<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PregnantPhone extends Model
{
    protected $fillable = [
        'nombre', 'telefono', 'relationship_id',
    ];
}
