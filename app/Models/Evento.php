<?php

namespace App\Models;

use App\Formatters\DateFormatter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evento extends Model
{
    use HasFactory;

    const ESTADO = [
        '1' => 'Activo',
        '2' => 'Inactivo',
    ];

    protected $table = 'eventos';
    protected $fillable = [
        'fecha',
        'estado',
        'lugares_disponibles',
        'actividad_id',
    ];

    protected $dates = [
        'fecha',
    ];

    public function actividad()
    {
        return $this->belongsTo(Actividad::class, 'actividad_id');
    }

    public function reservas()
    {
        return $this->hasMany(Reserva::class, 'evento_id');
    }

    public function getFechaAttribute($fecha)
    {
        $f = new DateFormatter($fecha);
        return $f->forForm();
    }
}
