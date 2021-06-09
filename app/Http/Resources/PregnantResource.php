<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PregnantResource extends JsonResource
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
            "numero_historia" => $this->numero_historia,
            "fum" => $this->fum ?? null,
            "fpp" => $this->fpp ?? null,
            "recomendaciones" => $this->recomendaciones ?? null,
            "antecedentes_patologicos" => $this->antecedentes_patologicos ?? null,
            "semana_gestacion" => $this->semana_gestacion ?? null,
            "gestas" => $this->gestas ?? null,
            "partos" => $this->partos ?? null,
            "vaccine_dt" => $this->vaccine_dt ?? null,
            "abortos" => $this->abortos ?? null,
            "cesarias" => $this->cesarias ?? null,
            "created_at" => $this->created_at,
        ];
    }
}
