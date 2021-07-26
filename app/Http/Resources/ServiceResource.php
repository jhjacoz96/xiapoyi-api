<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ServiceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "nombre" => $this->nombre,
            "descripcion" => $this->descripcion,
            "view_web" => $this->view_web,
            "activities" => $this->activities->map(function($query){
                return $query->id;
            }),
            "image" => $this->image ? $this->image->url : null,
        ];
    }
}
