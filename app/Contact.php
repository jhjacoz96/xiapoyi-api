<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $fillable = [
      'description1',  'description2', 'email', 'descripcion_phone1', 'descripcion_phone2', 'phone1', 'phone2', 'twitter', 'facebook', 'instagram'
    ];
}
