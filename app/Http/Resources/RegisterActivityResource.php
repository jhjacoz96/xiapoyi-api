<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RegisterActivityResource extends JsonResource
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
            "actividad" => $this->activityTreatment->actividad,
            "duracion" => $this->activityTreatment->duracion,
            "hora" => $this->activityTreatment->hora,
            "created_at" => $this->created_at,
        ];
    }
}
