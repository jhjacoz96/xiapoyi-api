<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Suscription extends Model
{
    protected $fillable = [
        'nombre', 'correo', 'filter_two_publication_id', 'filter_one_publication_id'
		,'filter_three_publication_id'
    ];

    public function filterOnePublication () {
    	return $this->belongsTo("App\FilterOnePublication", "filter_one_publication_id", "id");
    }
}
