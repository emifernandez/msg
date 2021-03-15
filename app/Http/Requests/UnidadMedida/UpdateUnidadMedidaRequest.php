<?php

namespace App\Http\Requests\UnidadMedida;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUnidadMedidaRequest extends FormRequest
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
            'nombre' => 'required|unique:unidades_medidas,nombre,' . $this->unidad->id,
            'abreviacion' => 'required',
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
            'nombre.required' => 'Debe introducir un nombre para la unidad de medida',
            'nombre.unique' => 'El nombre ingresado ya existe',
            'abreviacion.required' => 'Debe introducir una abreviación para la unidad de medida',
        ];
    }
}
