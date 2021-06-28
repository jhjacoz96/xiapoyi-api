<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\MemberPathology;
use App\MemberDisability;
use App\Pregnant;

class MemberShowResource extends JsonResource
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
            return $query->name;
        });
        $disability = MemberDisability::where('member_id', $this->id)->get();
        $arrayDisability = $disability->map(function($query) {
            return $query->name;
        });
        $prenatal = Pregnant::where('member_id', $this->id)->get();
         $fileFamily = $this->fileFamily;
        return [
            "zone_id" => $fileFamily->zone,
            "cultural_group_id" =>  $fileFamily->culturalGroup,
            "direccion_habitual" => $fileFamily->direccion_habitual,
            "id" => $this->id,
            "apellido" => $this->apellido,
            "nombre" => $this->nombre,
            "type_document_id" =>$this->typeDocument,
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
            "patologias" => $arrayPathologies,
            "discapacidades" => $arrayDisability,
            "embarazo" => $this->embarazo,
            "prenatal" => count( $prenatal) > 0 ? new PregnantResource($prenatal->last()->first()) : null ,
            "prenatal_todos" => count( $prenatal) > 0 ? PregnantResource::collection($prenatal) : null,
            "file_family_id" => $this->file_family_id,
            "diabetic_patient" => new DiabeticPatientShowResource($this->diabeticPatient) ?? null,
        ];
    }
}
