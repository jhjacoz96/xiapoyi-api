<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Medicine extends Model
{
    protected $fillable = [
        'name', 'description', 'presentation_id'
    ];

    public function presentation () {
        return $this->belongsTo('App\Presentation', 'presentation_id', 'id');
    }
}
