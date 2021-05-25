<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RiskFileFamilyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return  [
            "id" => $this->id,
            "name" => $this->name,
            "risk_classification_id" => new RiskClassificationResource($this->riskClassification),
            "level_risk_id" => $this->pivot->level_risk_id,
            "cumplio" => $this->pivot->cumplio,
            "causas" => $this->pivot->causas,
            "compromiso_familiar" => $this->pivot->compromiso_familiar,
            "compromiso_equipo" => $this->pivot->compromiso_equipo,
        ];
    }
}
