<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Service;

class ServicesWebResource extends JsonResource
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
        $Services = ServiceResource::collection($service);
        $arrayServices =  $Services->map( function ($query) {
            if ($query->view_web) return $query;
        });
        return [
            "id" => $this->id,
            "description1" => $this->description1,
            "description2" => $this->description2,
            "services" =>  $arrayServices,
        ];
    }
}
