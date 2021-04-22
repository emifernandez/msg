<?php

namespace App\Http\Requests\Evento;

use Illuminate\Foundation\Http\FormRequest;

class StoreEventoRequest extends FormRequest
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
            'fecha' => 'required',
            'actividad_id' => 'required',
            'lugares_disponibles' => 'required|numeric|min:1',
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
            'fecha.required' => 'Debe introducir una fecha para el evento',
            'actividad_id.required' => 'Debe introducir una actividad para el evento',
            'lugares_disponibles.numeric' => 'Debe introducir un valor numérico',
            'lugares_disponibles.min' => 'La cantidad de lugares disponibles debe ser mayor a cero',
            'lugares_disponibles.required' => 'Debe introducir una cantidad de lugares disponibles para el evento',
        ];
    }
}
