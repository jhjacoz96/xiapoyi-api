<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\PatientTreatment;
use App\RegisterwWight;
use App\RegisterGlucose;
use App\ActivityTreatment;
use App\RegisterTreatment;
use App\RegisterActivity;

class DiabeticPatientReportResource extends JsonResource
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
            "nombre" => $this->member->nombre,
            "apellido" => $this->member->apellido,
            "cedula" => $this->member->cedula,
            "groupAge" => $this->member->groupAge,
            "type_document_id" => $this->member->typeDocument,
            "patologias" => $this->member->pathologies->filter(function($query) {
                return $query->id != 1;
            })->pluck("name")->toArray(),
            "fecha_nacimiento" => $this->member->fecha_nacimiento,
            "gender_id" => $this->member->gender,
            "presion_arterial" => $this->presion_arterial,
            "pulso" => $this->pulso,
            "respiracion" => $this->respiracion,
            "saturacion_oxigeno" => $this->saturacion_oxigeno,
            "temperatura" => $this->temperatura,
            "peso" => $this->peso,
            "altura" => $this->altura,
            "descripcion_imc" => $this->descripcion_imc,
            "abdominal" => $this->abdominal,
            "circunferencia" => $this->circunferencia,
            "nivel_glusemia" => $this->nivel_glusemia,
            "dieta" => $this->dieta,
            "tratamiento_farmacologico" => $this->medicines->pluck("name")->toArray(),
            "tratamiento_no_farmacologico" => ActivityTreatmentResource::collection($this->activityTreatments),
            "registro_glucosa" => RegisterGlucose::where('diabetic_patient_id', $this->id)->orderBy('id', 'desc')->latest()->take(10) ->get(),
            "registro_peso" => RegisterwWight::where('diabetic_patient_id', $this->id)->orderBy('id', 'desc')->latest()->take(10) ->get(),
            "registro_tratamiento" => RegisterTreatmentResource::collection($registerTreatment),
            "registro_actividad" => RegisterActivityResource::collection($registerActivity),
            "created_at" => $this->created_at,
        ];
    }
}
