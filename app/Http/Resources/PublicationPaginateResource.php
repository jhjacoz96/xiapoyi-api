<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PublicationPaginateResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $pagination = [
            "total" => $this->total(),
            "current_page" => $this->currentPage(),
            "per_page" => $this->perPage(),
            "last_page" => $this->lastPage(),
            "from_page" => $this->firstItem(),
            "to" => $this->lastPage(),
        ];
        return [
            "pagination" => $pagination,
            "publications" => PublicationAllResource::collection($this->items()),
        ];
    }
}
