<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SuscriptionStoreRequest extends FormRequest
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
            "nombre" => "required|string",
            "filter_three_publication_id" => "sometimes|nullable",
            "filter_one_publication_id" => "sometimes|nullable",
            "filter_two_publication_id" => "sometimes|nullable",
            'correo' => [
                "required", "string",
                 Rule::unique('suscriptions')
                    ->where(function ($query) {
                       return $query->where('correo', $this->correo);
                    })
             ]
        ];
    }
}
