<?php

namespace App\Http\Requests\Producto;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductoRequest extends FormRequest
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
            'nombre' => 'required',
            'codigo_barra' => 'required|unique:productos,codigo_barra,' . $this->producto->id,
            'iva' => 'required|numeric|min:0|max:100',
            'unidad_id' => 'required',
            'marca_id' => 'required',
            'grupo_id' => 'required',

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
            'nombre.required' => 'Debe introducir un nombre para el producto',
            'codigo_barra.required' => 'Debe introducir un código de barras para el producto',
            'codigo_barra.unique' => 'El código de barras ingresado ya existe',
            'iva.required' => 'Debe introducir el IVA para el producto',
            'iva.numeric' => 'Debe introducir un valor numérico para el IVA',
            'iva.min' => 'El IVA no puede ser menor a cero',
            'iva.max' => 'El IVA no puede ser mayor a cien',
            'unidad_id.required' => 'Debe introducir una unidad de medida para el producto',
            'marca_id.required' => 'Debe introducir una marca para el producto',
            'grupo_id.required' => 'Debe introducir un grupo para el producto',
        ];
    }
}
