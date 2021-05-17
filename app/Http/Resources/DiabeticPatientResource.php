<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\PatientTreatment;

class DiabeticPatientResource extends JsonResource
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
            "presion_arterial" => $this->presion_arterial,
            "pulso" => $this->pulso,
            "respiracion" => $this->respiracion,
            "saturacion_oxigeno" => $this->saturacion_oxigeno,
            "temperatura" => $this->temperatura,
            "peso" => $this->peso,
            "altura" => $this->altura,
            "abdominal" => $this->abdominal,
            "circunferencia" => $this->circunferencia,
            "nivel_glusemia" => $this->nivel_glusemia,

            "dieta" => $this->dieta,
            "tratamiento_farmacologico" => PatientTreatment::where('diabetic_patient_id', $this->id)->get(),
            "tratamiento_no_farmacologico" => ActivityTreatmentResource::collection($this->activityTreatments),
        ];
    }
}
