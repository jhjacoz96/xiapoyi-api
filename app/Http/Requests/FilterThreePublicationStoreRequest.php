<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FilterThreePublicationStoreRequest extends FormRequest
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
            "filter_two_publication_id" => "required|integer",
        ];
    }
}
