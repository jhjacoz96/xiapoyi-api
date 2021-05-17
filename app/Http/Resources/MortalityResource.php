<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MortalityResource extends JsonResource
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
            "apellido" => $this->apellido,
            "edad" => $this->edad,
            "causa" => $this->causa,
            "relationship_id" => new $this->relationship,
        ];
    }
}
