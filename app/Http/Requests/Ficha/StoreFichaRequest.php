<?php

namespace App\Http\Requests\Ficha;

use Illuminate\Foundation\Http\FormRequest;

class StoreFichaRequest extends FormRequest
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
            'cliente_id' => 'required',
            'peso' => 'required|numeric|min:1',
            'altura' => 'required|numeric|min:1',
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
            'cliente_id.required' => 'Debe introducir un cliente para la ficha',
            'peso.required' => 'Debe introducir el peso para la ficha de cliente',
            'peso.numeric' => 'Debe introducir un valor numérico para el peso',
            'peso.min' => 'El peso debe ser mayor a cero',
            'altura.required' => 'Debe introducir la altura para la ficha de cliente',
            'altura.numeric' => 'Debe introducir un valor numérico para la altura',
            'altura.min' => 'La altura debe ser mayor a cero',
        ];
    }
}
