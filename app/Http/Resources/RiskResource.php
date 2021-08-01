<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RiskResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $activityEvolutions = $this->activityEvolutions->map(function($query){
            return $query->id;
        });
        return [
            "id" => $this->id,
            "name" => $this->name,
            "activity_evolutions" => $this->activityEvolutions,
            "activity_evolutions_id" =>  $activityEvolutions,
            "risk_classification" => $this->risk_classification_id,
            "risk_classification_id" => new RiskClassificationResource($this->riskClassification),
        ];
    }
}
