<?php

namespace App\Http\Requests\Cliente;

use Illuminate\Foundation\Http\FormRequest;

class UpdateClienteRequest extends FormRequest
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
            'apellido' => 'required',
            'tipo_documento' => 'required',
            'numero_documento' => 'required|max:10|unique:clientes,numero_documento,' . $this->cliente->id,
            'ruc' => 'max:10',
            'genero' => 'required',
            'email' => 'email',
            'fecha_nacimiento' => 'required',
            'fecha_ingreso' => 'required',

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
            'nombre.required' => 'Debe introducir un nombre para el cliente',
            'apellido.required' => 'Debe introducir un apellido para el cliente',
            'tipo_documento.required' => 'Debe introducir un tipo de documento para el cliente',
            'numero_documento.required' => 'Debe introducir un número de documento para el cliente',
            'numero_documento.max' => 'El número de documento del cliente no puede exceder 10 caracteres',
            'numero_documento.unique' => 'El número de documento ingresado ya existe',
            'ruc.max' => 'El RUC del cliente no puede exceder 10 caracteres',
            'genero.required' => 'Debe introducir un género para el cliente',
            'email.email' => 'Debe introducir un email válido',
            'fecha_nacimiento.required' => 'Debe introducir una fecha de nacimiento para el cliente',
            'fecha_ingreso.required' => 'Debe introducir una fecha de ingreso para el cliente',
        ];
    }
}