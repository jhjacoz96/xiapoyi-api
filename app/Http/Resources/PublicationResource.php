<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PublicationResource extends JsonResource
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
            "name" => $this->name,
            "description" => $this->description,
            "employee" => new EmployeeResource($this->employee),
            "created_at" => $this->created_at,
            "filter_two_publication_id" => new FilterTwoPublicationResource($this->filterTwoPublication),
            "filter_one_publication_id" => new FilterOnePublicationResource($this->filterOnePublication),
            "filter_three_publication_id" => new FilterThreePublicationResource($this->filterThreePublication),
            "resources" => ResourceResource::collection($this->resources),
            "image_mini" => $this->image,
        ];
    }
}
