<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\PatientTreatment;
use App\RegisterwWight;
use App\RegisterGlucose;
use App\ActivityTreatment;
use App\RegisterTreatment;
use App\RegisterActivity;

class DiabeticPatientShowResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $id = $this->id;
        $registerTreatment = RegisterTreatment::whereHas('patientTreatment', function($query) use($id) {
                $query->where('diabetic_patient_id', $id);
        })->latest()->take(10)->get();
        $registerActivity = RegisterActivity::whereHas('activityTreatment', function($query) use($id) {
                $query->where('diabetic_patient_id', $id);
        })->latest()->take(10)->get();
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
            "registro_glucosa" => RegisterGlucose::where('diabetic_patient_id', $this->id)->orderBy('id', 'desc')->latest()->take(10) ->get(),
            "registro_peso" => RegisterwWight::where('diabetic_patient_id', $this->id)->orderBy('id', 'desc')->latest()->take(10) ->get(),
            "registro_tratamiento" => RegisterTreatmentResource::collection($registerTreatment),
            "registro_actividad" => RegisterActivityResource::collection($registerActivity),
        ];
    }
}
