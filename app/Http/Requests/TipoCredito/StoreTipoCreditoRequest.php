<?php

namespace App\Http\Requests\TipoCredito;

use Illuminate\Foundation\Http\FormRequest;

class StoreTipoCreditoRequest extends FormRequest
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
            'descripcion' => 'required|unique:tipos_creditos,descripcion',
            'tasa_diaria' => 'required|numeric|min:0|max:100',
            'tasa' => 'required|numeric|min:0|max:100',
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
            'descripcion.required' => 'Debe introducir una descripción para el tipo de crédito',
            'descripcion.unique' => 'La descripción ingresada ya existe',
            'tasa_diaria.required' => 'Debe introducir la tasa diaria para el tipo de crédito',
            'tasa_diaria.numeric' => 'Debe introducir un valor numérico para la tasa diaria',
            'tasa_diaria.min' => 'La tasa diaria no puede ser menor a cero',
            'tasa_diaria.max' => 'la tasa diaria no puede ser mayor a cien',
            'tasa.required' => 'Debe introducir la tasa para el tipo de crédito',
            'tasa.numeric' => 'Debe introducir un valor numérico para la tasa',
            'tasa.min' => 'La tasa no puede ser menor a cero',
            'tasa.max' => 'la tasa no puede ser mayor a cien',
        ];
    }
}
