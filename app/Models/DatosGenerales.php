<?php

namespace App\Models;

use App\Formatters\DateFormatter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DatosGenerales extends Model
{
    use HasFactory;

    protected $table = 'datos_generales';
    protected $fillable = [
        'prefijo_factura',
        'nro_factura_desde',
        'nro_factura_hasta',
        'ultima_factura_impresa',
        'timbrado',
        'inicio_vigencia_timbrado',
        'fin_vigencia_timbrado',
        'nombre',
        'direccion',
        'telefono',
        'email',
        'ruc',
    ];

    protected $primaryKey = null;
    public $timestamps = false;
    public $incrementing = false;

    protected $dates = [
        'inicio_vigencia_timbrado',
        'fin_vigencia_timbrado',
    ];

    public function getInicioVigenciaTimbradoAttribute($fecha_nacimiento)
    {
        return new DateFormatter($fecha_nacimiento);
    }

    public function getFinVigenciaTimbradoAttribute($fecha_nacimiento)
    {
        return new DateFormatter($fecha_nacimiento);
    }
}
