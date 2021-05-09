<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Carrusel extends Model
{
    protected $fillable = [
        'title', 'description', 'url',
    ];

    public function image(){
        return $this->morphOne('App\Image','imageable');
    }

    public function assignImage (object $data) {
        $imagen = $data;
        $nombre = 'image_carrusel'.$imagen->getClientOriginalName();
        $ruta = public_path().'/imagenWeb';
        $imagen->move($ruta, $nombre);
        
        $urlImagen['url']='/imagenWeb/'.$nombre;
        $this->image()->create($urlImagen);
    }
}
