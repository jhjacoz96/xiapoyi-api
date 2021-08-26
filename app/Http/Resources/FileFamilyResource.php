<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\RiskFile;
use App\LeveLRisk;

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
        $risks = RiskFileFamilyResource::collection($this->risks);
        $e = $this->risks()->wherePivot("level_risk_id","!=", 1)->get();
        $evaluations = RiskFileFamilyResource::collection($e);
         return [
            "id" => $this->id,
            "longitud" => $this->longitud,
            "latitud" => $this->latitud,
            "manzana" => $this->manzana,
            "direccion_habitual" => $this->direccion_habitual,
            "barrio" => $this->barrio,
            "numero_familia" => $this->numero_familia,
            "numero_historia" => $this->numero_historia,
            "numero_telefono" => $this->numero_telefono,
            "numero_casa" => $this->numero_casa,
            "zone_id" => $this->zone_id,
            "cultural_group_id" => $this->cultural_group_id,
            "miembros" => MemberResource::collection($this->members),
            "mortalidad" => MortalityResource::collection($this->mortalities),
            "riesgos" => $risks,
            "evaluacion" => $evaluations,
            "total_risk" => $this->total_risk,
            "level_total_id" => $this->level_total_id,
            "contaminacion" => $this->contaminationPoints,
            "sitios_tratamiento" => $this->treatmentSites,
            "telefono_celular_uno" => $this->telefono_celular_uno,
            "telefono_celular_dos" => $this->telefono_celular_dos,
            "correo" => $this->correo,
            "created_at"  => $this->created_at,
        ];  
    }
}
