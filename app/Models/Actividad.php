<?php

namespace App\Models;

use App\Formatters\DateFormatter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Actividad extends Model
{
    use HasFactory;

    const ESTADO = [
        '1' => 'Activo',
        '2' => 'Inactivo',
    ];

    const GENERO_HABILITADO = [
        '1' => 'Todos',
        '2' => 'Femenino',
        '3' => 'Masculino',
    ];

    protected $table = 'actividades';
    protected $fillable = [
        'nombre',
        'dias',
        'hora_inicio',
        'hora_fin',
        'fecha_inicio',
        'fecha_fin',
        'servicio_id',
        'empleado_id',
        'salon_id',
        'genero_habilitado',
        'estado',
    ];

    protected $dates = [
        'hora_inicio',
        'hora_fin',
        'fecha_inicio',
        'fecha_fin',
    ];

    public function empleado()
    {
        return $this->belongsTo(Empleado::class, 'empleado_id',);
    }

    public function salon()
    {
        return $this->belongsTo(Salon::class, 'salon_id',);
    }

    public function servicio()
    {
        return $this->belongsTo(Servicio::class, 'servicio_id',);
    }

    public function eventos()
    {
        return $this->hasMany(Evento::class, 'actividad_id');
    }

    public function setNombreAttribute($nombre)
    {
        $this->attributes['nombre'] = mb_strtolower($nombre, "UTF-8");
    }

    public function getNombreAttribute($nombre)
    {
        return ucwords($nombre);
    }

    public function getHoraInicioAttribute($hora_inicio)
    {
        return new DateFormatter($hora_inicio);
    }

    public function getHoraFinAttribute($hora_fin)
    {
        return new DateFormatter($hora_fin);
    }

    public function getFechaInicioAttribute($fecha_inicio)
    {
        return new DateFormatter($fecha_inicio);
    }

    public function getFechaFinAttribute($fecha_fin)
    {
        return new DateFormatter($fecha_fin);
    }

    public function getDias()
    {
        $dias = str_split($this->dias);
        $texto = '';
        foreach ($dias as $i => $dia) {
            switch ($i) {
                case '0':
                    $texto = $texto . ($dia == '1' ? 'DOM ' : '');
                    break;
                case '1':
                    $texto = $texto . ($dia == '1' ? 'LUN ' : '');
                    break;
                case '2':
                    $texto = $texto . ($dia == '1' ? 'MAR ' : '');
                    break;
                case '3':
                    $texto = $texto . ($dia == '1' ? 'MIE ' : '');
                    break;
                case '4':
                    $texto = $texto . ($dia == '1' ? 'JUE ' : '');
                    break;
                case '5':
                    $texto = $texto . ($dia == '1' ? 'VIE ' : '');
                    break;
                case '6':
                    $texto = $texto . ($dia == '1' ? 'SAB' : '');
                    break;
            }
        }
        return $texto;
    }
}
