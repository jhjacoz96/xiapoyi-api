<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\PatientTreatment;

class RegisterTreatmentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $treatment = PatientTreatment::find($this->patient_treatment_id);
        return [
            "id" => $this->id,
            "patient_treatment_id" => $treatment->id,
            "dosis" => $treatment->dosis,
            "hora" => $treatment->hora,
            "measure" => new MeasureResource($treatment->measure),
            "medicine" => new MedicineResource($treatment->medicine),
            "presentation" => new PresentationResource($treatment->presentation),
            "created_at" => $this->created_at,
        ];
    }
}
