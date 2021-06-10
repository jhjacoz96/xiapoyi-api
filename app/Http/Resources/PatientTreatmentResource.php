<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PatientTreatmentResource extends JsonResource
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
            "dosis" => $this->dosis,
            "hora" => $this->hora,
            "measure" => new MeasureResource($this->measure),
            "medicine" => new MedicineResource($this->medicine),
            "presentation" => new PresentationResource($this->presentation),
        ];
    }
}
