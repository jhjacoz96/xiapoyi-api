<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AuditResource extends JsonResource
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
            "user" => $this->user->employee,
            "event" => $this->event,
            "auditable_type" => substr($this->auditable_type, 4),
            "auditable_id" => $this->auditable_id,
            "new_values" => $this->new_values,
            "old_values" => $this->old_values,
             "created_at" => $this->created_at,
        ];
    }
}
