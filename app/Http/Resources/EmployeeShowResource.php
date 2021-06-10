<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EmployeeShowResource extends JsonResource
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
            "gender_id" => $this->gender->nombre,
            "canton_id" => $this->canton->name,
            "province_id" => $this->province->name,
            "type_document_id" => $this->type_document_id ? null,
            "type_employee_id" => $this->type_employee->name ? null,
            "specialty_id" => $this->specialty_id ? null,
            "role_id" => $this->user->roles[0]->name ?? null,
            "image" => $this->image ?? null,
            "email" => $this->user->email,
        ];
    }
}
