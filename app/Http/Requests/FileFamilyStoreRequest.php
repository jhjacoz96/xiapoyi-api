<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FileFamilyStoreRequest extends FormRequest
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
            "manzana" => "required|string",
            "direccion_habitual" => "required|string",
            "barrio" => "required|string",
            "numero_familia" => "required|string",
            "numero_historia" => "required|string",
            "numero_telefono" => "required|string",
            "numero_casa" => "required|string",
            "zone_id" => "required|integer",
            "cultural_group_id" => "required|integer",
            "miembros" => "required|array",
            "mortalidad" => "nullable|sometimes|array",
        ];
    }
}
