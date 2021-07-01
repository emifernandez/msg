<?php

namespace App\Http\Requests\Venta;

use Illuminate\Foundation\Http\FormRequest;

class ReporteVentaRequest extends FormRequest
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
            'fecha_inicio' => 'required',
            'fecha_fin' => 'required',
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
            'fecha_inicio.required' => 'Debe introducir una fecha',
            'fecha_fin.required' => 'Debe introducir una fecha',
        ];
    }
}
