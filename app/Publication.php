<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;


class Publication extends Model  implements Auditable
{
    use AuditableTrait;
    
    protected $fillable = [
        'name', 'description', 'employee_id', 'filter_two_publication_id', 'filter_one_publication_id', 'filter_three_publication_id'
    ];

    public function image(){
        return $this->morphOne('App\Image','imageable');
    }

    public function employee () {
        return $this->belongsTo('App\Employee', 'employee_id', 'id');
    }

    public function resource () {
        return $this->hasOne('App\Resource', 'publication_id', 'id');
    }

    public function filterTwoPublication () {
        return $this->belongsTo('App\FilterTwoPublication', 'filter_two_publication_id', 'id');
    }

    public function filterOnePublication () {
        return $this->belongsTo('App\FilterOnePublication', 'filter_one_publication_id', 'id');
    }

    public function filterThreePublication () {
        return $this->belongsTo('App\FilterThreePublication', 'filter_three_publication_id', 'id');
    }

    public function assingImageMini (object $data) {    
        $imagen = $data;
        $nombre = 'image_mini_publication'.$imagen->getClientOriginalName();
        $ruta = public_path().'/imagenPublication';
        $imagen->move($ruta, $nombre);
        
        $urlImagen['url']='/imagenPublication/'.$nombre;
        $this->image()->create($urlImagen);
    }

    public function assingResources (array $data) {
        $children = $this->resources;
        $resources_items = collect($data);

        $deleted_ids = $children->filter(function ($child) use ($resources_items) {
            return in_array($resources_items, $child->id);
        })->map(function ($child) {
            $id = $child->id;
            $child->delete();
            return $id;
        });

        /**
         * Añadí esta sección por si es necesario actualizar
         * las causas que ya se encuentran relacionados.
         */
        $updates = $resources_items->filter(function ($model) {
            return isset($model['id']);
        })->map(function ($model) {
            $this->resources->map(function ($c) use ($model) {
                $c->updateOrCreate([
                    'id' => $model['id'],
                  
                ],[
                    'type_resource' => $model['type_resource'],
                    'url'  => $model['url'],
                    'publication_id' => $model['publication_id'],
                ]);
            });
        });

        $attachments = $resources_items->filter(function ($model) {
            return !isset($model['id']);
        })->map(function ($model) use ($deleted_ids) {
            $model['id'] = $deleted_ids->pop();
            return $model;
        })->toArray();

        $this->resources()->createMany($attachments);
    }
}
