<?php

namespace App\Http\Requests\Actividad;

use Illuminate\Foundation\Http\FormRequest;

class StoreActividadRequest extends FormRequest
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
            'fecha_inicio' => $this->request->get('fecha_fin') == null ? 'required' : 'required|before_or_equal:fecha_fin',
            'hora_inicio' => 'required|before:hora_fin',
            'hora_fin' => 'required|after:hora_inicio',
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
            'fecha_inicio.required' => 'Debe introducir una Fecha Desde para la actividad',
            'fecha_inicio.before_or_equal' => 'La Fecha Desde no puede ser mayor a la Fecha Hasta',
            'hora_inicio.required' => 'Debe introducir una hora de inicio para la actividad',
            'hora_inicio.before' => 'La Hora Desde no puede ser mayor o igual a la Hora Hasta',
            'hora_fin.required' => 'Debe introducir una hora de finalización para la actividad',
            'hora_fin.after' => 'La Hora Hasta no puede ser menor o igual a la Hora Desde',
            'empleado_id.required' => 'Debe introducir un empleado para la actividad',
            'servicio_id.required' => 'Debe introducir un servicio para la actividad',
            'salon_id.required' => 'Debe introducir un salón para la actividad',
        ];
    }
}
