<?php

namespace App\Http\Requests\Servicio;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateServicioRequest extends FormRequest
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
            'descripcion' => [
                'required',
                Rule::unique('servicios')->ignore($this->servicio->id),
            ],
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
            'descripcion.required' => 'Debe introducir una descripción para el servicio',
            'descripcion.unique' => 'La descripción ingresada ya existe',
        ];
    }
}
