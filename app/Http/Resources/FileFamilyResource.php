<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FileFamilyResource extends JsonResource
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
            "manzana" => $this->manzana,
            "direccion_habitual" => $this->direccion_habitual,
            "barrio" => $this->barrio,
            "numero_familia" => $this->numero_familia,
            "numero_historia" => $this->numero_historia,
            "numero_telefono" => $this->numero_telefono,
            "numero_casa" => $this->numero_casa,
            "zone_id" => new ZoneResource($this->zone),
            "cultural_group_id" => new CulturalGroupResource($this->CulturalGroup),
            "miembros" => MemberResource::collection($this->members),
            "mortalidad" => MortalityResource::collection($this->mortalities),
            "riesgos" => $this->risks,
            "total_risk" => $this->total_risk,
            "level_total_id" => new LevelRiskResource($this->levelTotal),
            "contaminacion" => $this->contaminationPoints,
            "sitios_tratamiento" => $this->treatmentSites,
        ];  
    }
}
