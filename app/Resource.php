<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Resource extends Model
{
    protected $fillable = [
        'publication_id', 'type_resource', 'url'
    ];

    public function image(){
        return $this->morphOne('App\Image','imageable');
    }

    public function publication () {
    	return $this->belongsTo('App\Publication', 'publication_id', 'id');
    }

    public function assingResource (object $data) {    
        $imagen = $data;
        $nombre = 'resource_publication'.$imagen->getClientOriginalName();
        $ruta = public_path().'/imagenPublication';
        $imagen->move($ruta, $nombre);
        
        $urlImagen['url']='/imagenPublication/'.$nombre;
        return $this->image()->create($urlImagen);
    }

    
}
