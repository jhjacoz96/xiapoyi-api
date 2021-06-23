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
        $services =  $service->filter(function ($query) {
           return $query->view_web == 1;
        });
        $arrayServices = ServiceListResource::collection($services);
        return [
            "id" => $this->id,
            "description1" => $this->description1,
            "description2" => $this->description2,
            "services" =>  $arrayServices,
        ];
    }
}
