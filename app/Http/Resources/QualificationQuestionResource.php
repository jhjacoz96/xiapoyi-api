<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class QualificationQuestionResource extends JsonResource
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
            "id" => $this["id"],
            "nombre" => $this["nombre"],
            "level_id" => isset($this["pivot"]) ? $this["pivot"]["qualification_level_id"] : null
        ];
    }
}
