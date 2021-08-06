<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EmployeeResource extends JsonResource
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
            "document" => $this->document,
            "phone" => $this->phone,
            "address" => $this->address,
            "status" => $this->status,
            "gender_id" => $this->gender_id,
            "canton_id" => $this->canton_id,
            "province_id" => $this->province_id,
            "type_document_id" => $this->type_document_id,
            "type_employee_id" => $this->type_employee_id,
            "specialty_id" => $this->specialty_id,
            "role_id" => $this->user->roles[0]->name ?? null,
            "user_id" => $this->user->id,
            "image" => $this->image ?? null,
        ];
    }
}
