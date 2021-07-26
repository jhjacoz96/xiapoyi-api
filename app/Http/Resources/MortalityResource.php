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
            "relationship_id" => $this->relationship_id,
            "fecha_fallecimiento" => $this->fecha_fallecimiento,
            "cause_mortality_id" => $this->cause_mortality_id,
            "member_id" => $this->member_id,
        ];
    }
}
