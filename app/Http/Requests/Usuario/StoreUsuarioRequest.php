<?php

namespace App\Http\Requests\Usuario;

use Illuminate\Foundation\Http\FormRequest;

class StoreUsuarioRequest extends FormRequest
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
            'email' => 'required|email|unique:users,email',
            'name' => 'required',
            'lastname' => 'required',
            'password' => 'required|confirmed|min:8',
            'rol' => 'required',
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
            'email.required' => 'Debe introducir el email para el usuario',
            'email.email' => 'Debe introducir un email válido para el usuario',
            'email.unique' => 'El email ingresado ya existe',
            'name.required' => 'Debe introducir el nombre para el usuario',
            'lastname.required' => 'Debe introducir el apellido para el usuario',
            'password.required' => 'Debe introducir una contraseña para el usuario',
            'password.confirmed' => 'La confirmación de contraseña no coincide',
            'password.min' => 'La contraseña debe contener al menos 8 caracteres',
            'rol.required' => 'Debe introducir un rol para el usuario',
        ];
    }
}
