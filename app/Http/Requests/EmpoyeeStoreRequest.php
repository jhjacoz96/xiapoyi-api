<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmpoyeeStoreRequest extends FormRequest
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
            'name' => "required|string",
            'phone' => "required|string",
            'document' => "required|string",
            'gender_id' => "required|integer",
            'type_document_id' => "required|integer",
            "province_id"=> "required|integer",
            "canton_id"=> "required|integer",
            'address' => "required|string",
            'email' => "required|string"
        ];
    }
}
