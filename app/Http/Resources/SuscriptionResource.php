<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SuscriptionResource extends JsonResource
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
            "correo" => $this->correo,
            "filter_two_publication_id" => $this->filter_two_publication_id,
            "filter_one_publication_id" => $this->filter_one_publication_id,
            "filter_three_publication_id" => $this->filter_three_publication_id,
        ];
    }
}
