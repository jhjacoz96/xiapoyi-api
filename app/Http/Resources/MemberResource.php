<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MemberResource extends JsonResource
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
            "apellido" => $this->apellido,
            "nombre" => $this->nombre,
            "type_document_id" => new TypeDocumentResource($this->typeDocument),
            "cedula" => $this->cedula,
            "correo" => $this->correo,
            "ocupacion" => $this->ocupacion,
            "fecha_nacimiento" => $this->fecha_nacimiento,
            "groupAge" => new GroupAgeResource($this->GroupAge),
            "vacunacion" => $this->vacunacion,
            "salud_bucal" => $this->salud_bucal,
            "scholarship_id" => $this->scholarship,
            "relationship_id" => $this->relationship,
            "gender_id" => $this->gender,
            "patologias" => PathologyResource::collection($this->pathologies),
            "discapacidades" => DisabilityResource::collection($this->disabilities),
            "embarazo" => $this->embarazo,
            "prenatal" => new PregnantResource($this->pregnant) ?? null,
            "diabetic_patient" => new DiabeticPatientResource($this->diabeticPatient) ?? null,
        ];
    }
}
