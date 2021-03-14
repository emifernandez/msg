<?php

namespace App\Http\Requests\Empleado;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEmpleadoRequest extends FormRequest
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
            'numero_documento' => 'required|max:10|unique:empleados,numero_documento,' . $this->empleado->id,
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
            'nombre.required' => 'Debe introducir un nombre para el empleado',
            'apellido.required' => 'Debe introducir un apellido para el empleado',
            'tipo_documento.required' => 'Debe introducir un tipo de documento para el empleado',
            'numero_documento.required' => 'Debe introducir un número de documento para el empleado',
            'numero_documento.max' => 'El número de documento del cliente no puede exceder 10 empleado',
            'numero_documento.unique' => 'El número de documento ingresado ya existe',
            'genero.required' => 'Debe introducir un género para el empleado',
            'email.email' => 'Debe introducir un email válido',
            'fecha_nacimiento.required' => 'Debe introducir una fecha de nacimiento para el empleado',
            'fecha_ingreso.required' => 'Debe introducir una fecha de ingreso para el empleado',
        ];
    }
}
