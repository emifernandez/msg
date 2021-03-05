<?php

namespace App\Http\Requests\Salon;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateSalonRequest extends FormRequest
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
            'nombre' => [
                'required',
                Rule::unique('salones')->ignore($this->salon->id),
            ],
            'capacidad' => 'required|numeric|min:0',
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
            'nombre.required' => 'Debe introducir un nombre para el salón',
            'nombre.unique' => 'El nombre ingresado ya existe',
            'capacidad.required' => 'Debe introducir una capacidad para el salón',
            'capacidad.numeric' => 'Debe introducir un valor numérico para la capacidad',
            'capacidad.min' => 'La capacidad no puede ser menor a cero',
        ];
    }
}
