<?php

namespace App\Http\Requests\Servicio;

use Illuminate\Foundation\Http\FormRequest;

class StoreServicioRequest extends FormRequest
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
            'descripcion' => 'required|unique:servicios,descripcion',
            'precio' => 'required|numeric|min:0',
            'iva' => 'required|numeric|min:0|max:100',
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
            'precio.required' => 'Debe introducir un precio para el servicio',
            'precio.numeric' => 'Debe introducir un valor numérico para el precio',
            'precio.min' => 'El precio no puede ser menor a cero',
            'iva.required' => 'Debe introducir el IVA para el servicio',
            'iva.numeric' => 'Debe introducir un valor numérico para el IVA',
            'iva.min' => 'El IVA no puede ser menor a cero',
            'iva.max' => 'El IVA no puede ser mayor a cien',
        ];
    }
}
