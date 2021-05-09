<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Resource extends Model
{
    protected $fillable = [
        'publication_id', 'type_resource', 'url'
    ];

    
}
