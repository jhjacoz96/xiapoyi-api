<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ZoneUpdateRequest extends FormRequest
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
            "name" => "required|string",
            "code" => "required|string",
            "canton_id" => [
                "required", "integer",
                Rule::exists('cantons', "id")
            ],
            "province_id" => [
                "required", "integer",
                Rule::exists('provinces', "id")
            ]
        ];
    }
}
