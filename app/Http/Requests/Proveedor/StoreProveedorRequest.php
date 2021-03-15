<?php

namespace App\Http\Requests\Proveedor;

use Illuminate\Foundation\Http\FormRequest;

class StoreProveedorRequest extends FormRequest
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
            'razon_social' => 'required',
            'ruc' => 'required|max:10|unique:proveedores,ruc',
            'email' => 'email',
            'direccion' => 'required',

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
            'razon_social.required' => 'Debe introducir una razón social para el proveedor',
            'ruc.required' => 'Debe introducir un RUC para el proveedor',
            'ruc.max' => 'El RUC del proveedor no puede exceder 10 caracteres',
            'ruc.unique' => 'El RUC ingresado ya existe',
            'email.email' => 'Debe introducir un email válido',
            'direccion.required' => 'Debe introducir una dirección para el proveedor',
        ];
    }
}
