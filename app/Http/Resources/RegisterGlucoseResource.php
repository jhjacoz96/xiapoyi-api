<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RegisterGlucoseResource extends JsonResource
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
            "fecha" => $this->fecha,
            "hora" => $this->hora ?? null,
            "comida" => $this->comida,
            "nivel_glusemia" => $this->nivel_glusemia,
        ];
    }
}
