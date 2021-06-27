<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Member;

class ReportFileFamilyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        /*$jefe_familia = Member::whereHas('relationship', function($query) {
            $query->find(1);
        })->first();*/
       return [
            "id" => $this->id,
            "manzana" => $this->manzana,
            "direccion_habitual" => $this->direccion_habitual,
            "barrio" => $this->barrio,
            "numero_familia" => $this->numero_familia,
            "numero_historia" => $this->numero_historia,
            "numero_telefono" => $this->numero_telefono,
            "numero_casa" => $this->numero_casa,
            "zone_id" => $this->zone,
            "cultural_group_id" => $this->culturalGroup,
            "miembros" => MemberResource::collection($this->members),
            "mortalidad" => MortalityResource::collection($this->mortalities),
            //"jefe_familia" => $jefe_familia ? $jefe_familia->nombre : null,
            "riesgos" => RiskFileFamilyResource::collection($this->risks),
            "total_risk" => $this->total_risk,
            "level_total_id" => $this->levelTotal,
            "contaminacion" => $this->contaminationPoints,
            "sitios_tratamiento" => $this->treatmentSites,
            "created_at"  => $this->created_at,
        ];  
    }
}
