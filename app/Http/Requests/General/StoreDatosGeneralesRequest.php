<?php

namespace App\Http\Requests\General;

use Illuminate\Foundation\Http\FormRequest;

class StoreDatosGeneralesRequest extends FormRequest
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
            'timbrado' => 'required',
            'inicio_vigencia_timbrado' => 'required',
            'fin_vigencia_timbrado' => 'required',
            'prefijo_factura' => 'required',
            'nro_factura_desde' => 'required|numeric',
            'nro_factura_hasta' => 'required|numeric',
            'ultima_factura_impresa' => 'required|numeric',
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
            'nombre.required' => 'Debe introducir un nombre para el negocio',
            'timbrado.required' => 'Debe introducir un timbrado',
            'inicio_vigencia_timbrado.required' => 'Debe introducir una fecha de inicio',
            'fin_vigencia_timbrado.required' => 'Debe introducir una fecha final',
            'prefijo_factura.required' => 'Debe introducir un prefijo para la factura',
            'nro_factura_desde.required' => 'Debe introducir el numero de inicio del talonario',
            'nro_factura_desde.numeric' => 'Sólo puede introducir números',
            'nro_factura_hasta.required' => 'Debe introducir el numero final del talonario',
            'nro_factura_hasta.numeric' => 'Sólo puede introducir números',
            'ultima_factura_impresa.required' => 'Debe introducir la ultima factura emitida. Si no emitió ninguna introduzca cero',
            'nro_fultima_factura_impresaactura_desde.numeric' => 'Sólo puede introducir números',
        ];
    }
}
