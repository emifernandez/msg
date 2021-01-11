<?php

namespace App\Http\Requests\Perfil;

use Illuminate\Foundation\Http\FormRequest;

class StorePerfilRequest extends FormRequest
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
            'perfil'=>'required|unique:perfiles,perfil',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'perfil.required' => 'Debe introducir un nombre para el perfil',
            'perfil.unique' => 'El perfil ingresado ya existe',
        ];
    }
}
