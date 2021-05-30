<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Resource;

class PublicationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {;
        $resource = Resource::where('publication_id', $this->id)->first();
        return [
            "id" => $this->id,
            "name" => $this->name,
            "description" => $this->description,
            "employee" => new EmployeeResource($this->employee),
            "created_at" => $this->created_at,
            "filter_two_publication_id" => $this->filter_two_publication_id,
            "filter_one_publication_id" => $this->filter_one_publication_id,
            "filter_three_publication_id" => $this->filter_three_publication_id ?? null,
            "resource" => $resource["url"] ?? null,
            "type_resource" => $resource["type_resource"] ?? null,
            "image_mini" => $this->image ?? null,
        ];
    }
}
