<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Service;

class ServicesAllWebResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $service = Service::All();
        return [
            "id" => $this->id,
            "description1" => $this->description1,
            "description2" => $this->description2,
            "services" =>  ServiceResource::collection($service),
        ];
    }
}
