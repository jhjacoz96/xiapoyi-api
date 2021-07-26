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
        $activityEvolutions = $this->activityEvolutions;
        return  [
            "id" => $this->id,
            "name" => $this->name,
            "risk_classification_id" => new RiskClassificationResource($this->riskClassification),
            "activity_evolutions" => $activityEvolutions,
            "level_risk_id" => $this->pivot->level_risk_id,
            "cumplio" => $this->pivot->cumplio,
            "causas" => $this->pivot->causas,
            "fecha_evaluacion" => $this->pivot->fecha_evaluacion,
            "fecha_programacion" => $this->pivot->fecha_programacion,
            "compromiso_id" => $this->pivot->compromiso_id,
        ];
    }
}
