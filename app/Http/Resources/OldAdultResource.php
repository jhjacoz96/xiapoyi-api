<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Publication;

class OldAdultResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $lastsPublications = Publication::latest()->take(3)->get();
         return [
            "title" => $this->title,
            "description1" => $this->description1,
            "description2" => $this->description2,
            "publications" => PublicationAllResource::collection($lastsPublications),
        ];
    }
}
