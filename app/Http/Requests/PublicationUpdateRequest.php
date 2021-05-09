<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PublicationUpdateRequest extends FormRequest
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
            "description" => "required|string",
            "filter_three_publication_id" => "sometimes|nullable|integer",
            "filter_two_publication_id" => "required|integer",
            "filter_one_publication_id" => "required|integer",
            "image_mini" => "required|file",
            "resources" => "required|string",
        ];
    }
}
