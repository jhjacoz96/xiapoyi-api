<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmpoyeeUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => "sometimes|nullable|string",
            'phone' => "sometimes|nullable||string",
            'document' => "sometimes|nullable||string",
            'gender_id' => "sometimes|nullable||integer",
            'type_document_id' => "sometimes|nullable||integer",
            "province_id"=> "sometimes|nullable|integer",
            "canton_id"=> "sometimes|nullable|integer",
            'address' => "sometimes|nullable||string",
            'status' => 'sometimes|nullable|string',
            'type_employee_id' => 'sometimes|nullable|integer',
            'specialty_id' => 'sometimes|nullable|integer',
            'role_id' => 'sometimes|nullable|string'
        ];

    }
}
