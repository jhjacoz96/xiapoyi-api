<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\MemberPathology;
use App\MemberDisability;
use App\Pregnant;

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
        $pathologies = MemberPathology::where('member_id', $this->id)->get();
        $arrayPathologies = $pathologies->map(function($query) {
            return $query->pathology_id;
        });
        $disability = MemberDisability::where('member_id', $this->id)->get();
        $arrayDisability = $disability->map(function($query) {
            return $query->disability_id;
        });
        $prenatal = Pregnant::where('member_id', $this->id)->get();
        return [
            "id" => $this->id,
            "apellido" => $this->apellido,
            "nombre" => $this->nombre,
            "type_document_id" =>$this->type_document_id,
            "type_blood_id" =>$this->type_blood_id,
            "cedula" => $this->cedula,
            "correo" => $this->correo,
            "ocupacion" => $this->ocupacion,
            "fecha_nacimiento" => $this->fecha_nacimiento,
            "groupAge" => new GroupAgeResource($this->GroupAge),
            "vacunacion" => $this->vacunacion,
            "salud_bucal" => $this->salud_bucal,
            "scholarship_id" => $this->scholarship_id,
            "relationship_id" => $this->relationship_id,
            "gender_id" => $this->gender_id,
            "patologias" => $arrayPathologies,
            "discapacidades" => $arrayDisability,
            "embarazo" => $this->embarazo,
            "fallecido" => $this->fallecido,
            "prenatal" => count( $prenatal) > 0 ? new PregnantResource($prenatal->last()) : null ,
            "prenatal_todos" => count( $prenatal) > 0 ? PregnantResource::collection($prenatal) : null,
            "file_family_id" => $this->file_family_id,
            "diabetic_patient" => new DiabeticPatientResource($this->diabeticPatient) ?? null,
        ];
    }
}
