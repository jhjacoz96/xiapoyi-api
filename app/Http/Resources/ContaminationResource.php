<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ContaminationResource extends JsonResource
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
            "causa_contaminacion" => $this->causeContaminations->map(function($query){
                return $query->id;
            }),
            "causa_contaminacions" => $this->causeContaminations,
        ];
    }
}
