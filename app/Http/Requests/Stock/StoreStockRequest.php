<?php

namespace App\Http\Requests\Stock;

use Illuminate\Foundation\Http\FormRequest;

class StoreStockRequest extends FormRequest
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
            'lote' => 'required|unique:stock,lote',
            'cantidad_actual' => 'required|numeric|min:0',
            'cantidad_minima' => 'required|numeric|min:0',
            'cantidad_maxima' => 'min:0',
            'precio_compra' => 'required|numeric|min:1',
            'precio_venta' => 'required|numeric|min:1',
            'producto_id' => 'required',
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
            'lote.required' => 'Debe introducir un lote para el stock',
            'lote.unique' => 'El lote ingresado ya existe',
            'cantidad_actual.required' => 'Debe introducir la cantidad actual',
            'cantidad_actual.numeric' => 'Debe introducir un valor numérico para la cantidad actual',
            'cantidad_actual.min' => 'La cantidad actual no puede ser menor a cero',
            'cantidad_minima.required' => 'Debe introducir la cantidad mínima',
            'cantidad_minima.numeric' => 'Debe introducir un valor numérico para la cantidad mínima',
            'cantidad_minima.min' => 'La cantidad mínima no puede ser menor a cero',
            'cantidad_maxima.min' => 'La cantidad máxima no puede ser menor a cero',
            'precio_compra.required' => 'Debe introducir el precio de compra',
            'precio_compra.numeric' => 'Debe introducir un valor numérico para el precio de compra',
            'precio_compra.min' => 'El precio de compra debe ser mayor a cero',
            'precio_venta.required' => 'Debe introducir el precio de venta',
            'precio_venta.numeric' => 'Debe introducir un valor numérico para el precio de venta',
            'precio_venta.min' => 'El precio de venta debe ser mayor a cero',
            'producto_id.required' => 'Debe introducir un producto para el stock',
        ];
    }
}
