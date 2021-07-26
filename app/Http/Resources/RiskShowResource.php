<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RiskShowResource extends JsonResource
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
            "activity_evolutions" => $activityEvolutions,
            "risk_classification_id" => $this->risk_classification_id,
        ];
    }
}
