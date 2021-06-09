<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\RolHasPermissionResource;
use App\Employee;

class UserResource extends JsonResource
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
            "email" => $this->email,
            "role" => RolHasPermissionResource::collection($this->roles),
            "employee" => new EmployeeShowResource(Employee::where("user_id", $this->id)->first())
        ];
    }
}
