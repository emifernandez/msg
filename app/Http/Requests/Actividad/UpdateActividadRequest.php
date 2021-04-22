<?php

namespace App\Http\Requests\Actividad;

use Illuminate\Foundation\Http\FormRequest;

class UpdateActividadRequest extends FormRequest
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
            'fecha_inicio' => 'required',
            'hora_inicio' => 'required',
            'hora_fin' => 'required',
            'empleado_id' => 'required',
            'servicio_id' => 'required',
            'salon_id' => 'required',
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
            'nombre.required' => 'Debe introducir un nombre para la actividad',
            'fecha_inicio.required' => 'Debe introducir una fecha de inicio para la actividad',
            'hora_inicio.required' => 'Debe introducir una hora de inicio para la actividad',
            'hora_fin.required' => 'Debe introducir una hora de finalización para la actividad',
            'empleado_id.required' => 'Debe introducir un empleado para la actividad',
            'servicio_id.required' => 'Debe introducir un servicio para la actividad',
            'salon_id.required' => 'Debe introducir un salón para la actividad',
        ];
    }
}
