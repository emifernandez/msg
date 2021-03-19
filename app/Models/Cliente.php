<?php

namespace App\Models;

use App\Formatters\DateFormatter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    const ESTADO = [
        '1' => 'Activo',
        '2' => 'Inactivo',
    ];

    const TIPO_DOCUMENTO = [
        '1' => 'Cédula Identidad',
        '2' => 'Pasaporte',
        '3' => 'DNI',
    ];

    const TIPO_CLIENTE = [
        '1' => 'Físico',
        '2' => 'Jurídico',
    ];

    const CALIFICACION = [
        '1' => 'Muy Bajo',
        '2' => 'Bajo',
        '3' => 'Bueno',
        '4' => 'Muy Bueno',
        '5' => 'Excelente',
    ];

    const GENERO = [
        '1' => 'No especifica',
        '2' => 'Femenino',
        '3' => 'Masculino',
        '4' => 'Otro',
    ];

    protected $table = 'clientes';
    protected $fillable = [
        'nombre',
        'apellido',
        'razon_social',
        'tipo_documento',
        'tipo_cliente',
        'numero_documento',
        'ruc',
        'genero',
        'fecha_nacimiento',
        'direccion',
        'telefono',
        'email',
        'fecha_ingreso',
        'calificacion',
        'estado',
    ];

    protected $dates = [
        'fecha_nacimiento',
        'fecha_ingreso',
    ];

    public function setNombreAttribute($nombre)
    {
        $this->attributes['nombre'] = mb_strtolower($nombre, "UTF-8");
    }
    public function setApellidoAttribute($apellido)
    {
        $this->attributes['apellido'] = mb_strtolower($apellido, "UTF-8");
    }

    public function getNombreAttribute($nombre)
    {
        return ucwords($nombre);
    }
    public function getApellidoAttribute($apellido)
    {
        return ucwords($apellido);
    }

    public function getFechaNacimientoAttribute($fecha_nacimiento)
    {
        return new DateFormatter($fecha_nacimiento);
    }

    public function getFechaIngresoAttribute($fecha_ingreso)
    {
        return new DateFormatter($fecha_ingreso);
    }
}
